<script setup>
import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer, LMarker, LTooltip } from "@vue-leaflet/vue-leaflet";

</script>

<template>
    <div class="h-112.5 mx-10 mt-10">
        <LMap :zoom="24" :center="[34.10114, -118.34376]" class="border rounded-md" >
            <LTileLayer
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                layer-type="base"
                name="OpenStreetMap"
                attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            />
            <LMarker :lat-lng="[34.10114, -118.34376]">
                <LTooltip :options="{ permanent: true, direction: 'top' }">
                    7060 Hollywood Blvd, Los Angeles, CA
                </LTooltip>
            </LMarker>
        </LMap>
    </div>
</template>
