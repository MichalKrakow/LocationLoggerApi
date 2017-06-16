<template>
	<div class="teamControll" :style="{'border-color' : color}">
		<div class="comp-row">
			<span class="team-name" @click="zoomTo">{{name}}</span>
			<div class="pmd-switch pull-right">
		        <label>
		        	<span class="switch-label">widoczny</span>
		            <input ref="input" @change="onTeamChange" type="checkbox" checked="checked">
		            <span class="pmd-switch-label"></span>
		        </label>
		    </div>
	    </div>
	    <div class="comp-row team-stats">
	    	<span class="last-tick" title="ostatnia znana pozycja"> [ <i class="fa fa-clock-o"></i> 13:50:32 ] </span>
	    	<span class="accuracy" title="dokladnosc pomiaru"> [ <i class="fa fa-bullseye"></i> 5m ]</span>
	    	<span class="speed" title="predkosc"> [ <i class="fa fa-tachometer"></i> 3 km/h ]</span>
	    </div>
	</div>
</template>

<script>
export default {

  name: 'TeamControll',
  props: {
  	teamName: {
  		type: String,
  		default: 'brak nazwy'
  	},
  	id: {
  		type: Number,
  		requred: true
  	},
  	color: {
  		type: String,
  		default: '#ccc'
  	}
  },
  methods: {
  	zoomTo()
  	{
  		this.$emit('teamZoom', this.id);
  	},
  	onTeamChange(e)
  	{
  		this.$emit('teamChange',{ state:this.$refs.input.checked, id:this.id });
  	}
  },
  created(){
  	this.name = this.teamName;
  	this.co
  },
  data () {
    return {
    	name: '',
    	visible: true,
    };
  }
};
</script>

<style lang="sass" scoped>
.teamControll
	margin-top: 10px
	padding-bottom: 2px
	border-bottom: 1px solid #ccc !important
	border-left: 4px solid
	padding-left: 10px
	&:first-child
		margin-top: 0px
.comp-row
	display: block
	width: 100%
	span
		display: inline-block
.team-stats
	margin-top: 7px
	position: relative
	top: -7px
.team-name
	text-transform: uppercase
	font-size: 14px
	font-weight: bold
	cursor: pointer
.switch-label
	margin-right: 10px
	font-size: 11px
span.pmd-switch-label
	display: inline-block
.pmd-switch
	display: inline-block
</style>