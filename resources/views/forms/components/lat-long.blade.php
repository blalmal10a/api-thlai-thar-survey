<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" style="display: none">
    <div x-data="{ latlong: $wire.$entangle('{{ $getStatePath() }}') }" x-init="() => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((data) => {
                latlong = `${data.coords.latitude}, ${data.coords.longitude}`
            }, (err) => console.log(err))
    
        }
    }">
        <x-filament::input.wrapper>
            <x-filament::input type="text" x-model="latlong" ref="latlongref" />
        </x-filament::input.wrapper>

    </div>

</x-dynamic-component>
