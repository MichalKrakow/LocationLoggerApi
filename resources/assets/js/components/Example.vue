<template>
<div class="app">
    <v-map ref="map" @l-move="move" style="height: 100%" :zoom="zoom" :center="center" class="map">
        <v-tilelayer :url="url" :attribution="attribution" ></v-tilelayer>
        <v-marker v-for="item in markers" 
            :icon="item.icon" 
            :key="item.id" 
            :lat-lng="item.position"
            :color="item.color"
            v-if="item.show">
            <v-popup :content="'lat: ' + item.position.lat + '<br/>lng: ' + item.position.lng "></v-popup>
        </v-marker>
        <v-polyline v-for="line in markers"
            v-bind:key="line.id" 
            :lat-lngs="line.polyline.latlngs" 
            :color="line.polyline.color"
            v-if="line.show" >
        </v-polyline>
    </v-map>
    <div class="sidebar">
        <form @submit.prevent="onSubmit">
            <div class="form-group">
                <datepicker language="pl" class="form-controll" monday-first :value="date"></datepicker>
            </div>
            <div class="form-controll">
                <TeamControll v-for="team in markers" 
                    :key="team.id"
                    :id="team.id"
                    :teamName="team.name"
                    :color="team.color"
                    @teamChange="teamChange"
                    @teamZoom="teamZoom">
                </TeamControll>
            </div>
        </form>
    </div>
</div>
</template>

<script>
import Vue2Leaflet from 'vue2-leaflet';
import Datepicker from 'vuejs-datepicker';
import TeamControll from './TeamControll';

L.Icon.Default.imagePath = '.';
L.Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});
    export default {
        created() {
            this.updateData();
        },
        mounted() {
            this.$refs.map.mapObject.attributionControl.setPrefix('');
        },
        components: {
            'v-map': Vue2Leaflet.Map,
            'v-tilelayer' :Vue2Leaflet.TileLayer,
            'v-marker': Vue2Leaflet.Marker,
            'v-tooltip': Vue2Leaflet.Tooltip,
            'v-popup': Vue2Leaflet.Popup,
            'v-polyline': Vue2Leaflet.Polyline,
            'Datepicker': Datepicker,
            'TeamControll': TeamControll,
        },
        methods: {
            teamChange(e)
            {
                // todo - validation if exist
                this.markers.find(x => x.id === e.id).show = e.state;
            },
            teamZoom(e)
            {
                let zoomTo = this.markers.find(x => x.id === e);
                //this.center = zoomTo.position;
                this.$refs.map.mapObject.setView(zoomTo.position,16);
            },
            move(e){
                this.currentCenter = this.$refs.map.mapObject.getCenter();
            },
            updateData()
            {
                axios.post('/getusers', this.$data)
                .then(response => {
                    let marks = [];
                    for(let marker of response.data)
                    {
                        console.log(marker);
                        let ob = {
                            'id' : marker.id,
                            'name' : marker.name,
                            'color' : marker.color,
                            'position' : marker.positions[0],
                            'show' : true,
                            'polyline' : {
                                latlngs: marker.positions.map(loc => {
                                    return [loc['lat'],loc['lng']];
                                }),
                                color: marker.color
                            },
                            'icon' : L.divIcon({
                                    className: 'team-marker',
                                    'html' : `<div class="caption" style="background: ${marker.color}">${marker.name}</div>`,
                                    'iconAnchor' : [3,3]
                            }) 
                        }
                        marks.push(ob);
                    }
                    console.log(marks);
                    this.markers = marks;
                });
            },
            onSubmit(){
                this.updateData();
            }
        },
        data(){
            return {
                date: new Date(Date.now()),
                email: '',
                name: '',
                zoom:13,
                markers: [],
                currentCenter: L.latLng(50.029206, 19.875053),
                center: L.latLng(50.029206, 19.875053),
                url:'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                attribution:'',
                marker: L.latLng(50.029206, 19.875053),
            }
        }
    }
</script>

<style lang="sass">
.vdp-datepicker__calendar
    width: 100% !important
.vdp-datepicker
    input
        width: 100%
        padding: 5px 10px 3px
.team-marker
    .caption
        color: #fff
        position: absolute
        width: auto
        padding: 2px 5px
        left: 12px
        top: -9px
        border-radius: 3px
        box-shadow: 0px 2px 1px rgba(0,0,0,0.3)
        text-shadow: 0px 1px 0px rgba(0,0,0,0.3)
        opacity: 0.9

        &:before
            content: ''
            width: 5px
            height: 5px
            box-shadow: 0px 1px 2px rgba(0,0,0,0.4)
            //border: 1px solid #000
            position: absolute
            background-color: inherit
            border-radius: 50%

            top: 9px
            left: -12px

#app, .app
    width: 100%
    height: 100%
.map
    width: 100%
    height: 100%
.sidebar
    position: absolute
    top: 0px
    right: 0px
    width: 25%
    padding: 10px 20px 20px 20px
    min-width: 300px
    z-index: 1000
    background-color: #FFF

.container
    margin-top: 30px
</style>
