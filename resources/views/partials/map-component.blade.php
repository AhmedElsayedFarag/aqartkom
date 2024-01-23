    <input type="hidden" id="lat" name="{{ $coordinate->latName }}" value="{{ $coordinate->lat }}" />
    <input type="hidden" id="long" name="{{ $coordinate->longName }}" value="{{ $coordinate->long }}" />

    <div class="row" style="height:400px">
        <input id="pac-input" class="controls" type="text" placeholder="Search Box" />
        <div id="map" style="height:100%"></div>
    </div>
