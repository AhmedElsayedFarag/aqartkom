<?php

namespace Modules\Auth\Services;

use App\DataTransferObjects\QrcodeDto;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Requests\Api\RegisterRequest;
use Illuminate\Support\Str;
use Modules\Auth\Entities\CompanyProfile;
use Modules\Auth\Http\Requests\Api\CompanyRequest;
use Modules\Auth\Http\Requests\Api\UpdateCompanyRequest;

class CompanyProfileService
{
    public static function create(RegisterRequest $request, User $user)
    {
        DB::transaction(function () use ($request, $user) {
            $uuid
                = Str::uuid();
            $data = $request->merge([
                'commercial_register_number' => $request->get('advertisement_number'),

                'uuid' => $uuid,
                'whatsapp_number' => $user->phone,
                'qr_code' => create_qr_code(new QrcodeDto(
                    route('front.companies.show', ['company' => $uuid]),
                    'companies'
                ))
            ])->all();
            unset($data['logo']);
            $data['logo'] = $request->file('logo')->store('', ['disk' => 'companies']);
            $user->companyProfile()->create($data);
            $user->assignRole('company');
        });
    }
    public static function update(UpdateCompanyRequest $request, CompanyProfile $profile)
    {
        DB::transaction(function () use ($request, $profile) {
            if ($request->hasFile('logo')) {
                $request->merge([
                    'logo' => $request->file('logo')->store('', ['disk' => 'companies']),
                ]);
            }
            $profile->update($request->all());
            auth()->user()->update($request->only('name', 'email', 'phone'));
        });
    }
}
