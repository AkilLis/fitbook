<template>
	<polygon @click="polygonMouseClick" v-on:mouseout="polygonMouseOut" v-on:mouseover="polygonMouseOver" class="hex">
	</polygon>
</template>

<script>

	function CustomPoint(x , y) {
	    this.x = x;
	    this.y = y;

	    this.toString = function () {
	    	return this.x + ',' + this.y
	    }
    }

	export default {
		props : {
			length : {
				type : Number,
				required : true
			},

			padding : {
				type : Number,
				default : 0
			},

			item : {

			},

			bgColor : {
				default : ''
			},

			filterId: {
				default : ''
			},

			borderColor : {
				default : '#ccc'
			},

			borderWidth : {
				default : 0
			},

			rotate : {
				default : 'horizontal'
			},

			cordX : {
				type : Number,
			},

			cordY : {
				type : Number,
			},
		},

		data () {
			return {
				opp : 0,
				adj : 0,
				topLeft : null,
				topRight : null,
				centerLeft : null,
				centerRight : null,
				bottomLeft : null,
				bottomRight : null,
			}
		},

		ready : function () {
			this.calcOpp(this.length)
			this.calcAdj(this.length, this.opp)

			if(this.rotate == "horizontal") {
				this.calcPointsHorizontal()
			} else {
				this.calcPointsVertical()
			}

			this.draw()
			this.fillBgColor()
			this.fillStroke()
			this.setFilterId()
		},

		methods : {
			polygonMouseOut : function () {
				this.$emit('mouseout', this.item)
			},

			polygonMouseOver : function (e) {
				this.$emit('hovered', this.item, e)
			},

			polygonMouseClick : function () {
				this.$emit('clicked', this.item)
			},

			calcOpp : function(length) {
				this.opp = length / 2
			},

			calcAdj : function(length, opp) {
				this.adj = Math.round(Math.sqrt(Math.pow(length, 2) - Math.pow(opp, 2)))
			},

			calcPointsHorizontal : function () {
				this.topLeft = new CustomPoint(this.opp + this.cordX, this.cordY)
				this.topRight = new CustomPoint(this.opp + this.length + this.cordX, this.cordY)
				this.centerLeft = new CustomPoint(this.cordX, this.cordY + this.adj)
				this.centerRight = new CustomPoint(this.opp * 2 + this.length + this.cordX, this.cordY + this.adj)
				this.bottomLeft = new CustomPoint(this.opp + this.cordX, this.cordY + 2 * this.adj)
				this.bottomRight = new CustomPoint(this.opp + this.cordX + this.length, this.cordY + this.adj * 2)
			}, 

			calcPointsVertical : function () {

			},

			getPoints : function () {
				return this.topLeft.toString() + ' ' + 
					   this.topRight.toString() + ' ' + 
					   this.centerRight.toString() + ' ' + 
					   this.bottomRight.toString() + ' ' + 
					   this.bottomLeft.toString() + ' ' +
					   this.centerLeft.toString(); 
			},

			draw : function () {
				$(this.$el).attr('points', this.getPoints())
			},

			fillBgColor : function() {
				$(this.$el).attr('fill', this.bgColor)	
			},

			fillStroke : function() {
				$(this.$el).attr('stroke', this.borderColor).attr('stroke-width',this.borderWidth);
			},
			setFilterId : function() {
				$(this.$el).attr('filter', this.filterId);
			}
		}

	}
</script>
<style lang="scss" scoped>
	.hexagon--tooltip {
	    pointer-events:none; /*let mouse events pass through*/
	    opacity:0;
	    transition: opacity 0.3s;
	    text-shadow:1px 1px 0px gray;
	}

	polygon:hover + g.hexagon--tooltip {
	  opacity:1;
	}
</style>