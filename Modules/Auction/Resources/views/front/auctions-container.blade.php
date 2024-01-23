            <div class="row">
                @foreach ($auctions as $auction)
                    @include('auction::front.auction-component')
                @endforeach

            </div>
