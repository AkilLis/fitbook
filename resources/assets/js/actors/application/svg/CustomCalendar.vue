<template>
    <svg version="1.1" width="800" height="180">
    	<g transform="translate(40, 30)">
	        <custom-hexagon
	        	v-for="activity in hexagons"
	        	:bg-color="calcColor(activity.duration)" 
	        	:length.sync="length" 
	        	:cord-x="activity.x" 
	        	:cord-y="activity.y"
	        	:item="activity"
	        	@hovered="onHexagonHover"
	        	@mouseout="onHexagonMouseOut"
	        	@clicked="onHexagonClick">
	        </custom-hexagon>

	        <text v-for="week in weeks"
	        	  class="Calendar__Month"
	        	  :transform="'translate(-25, ' + week.distance + ')'">
	        	{{week.label | weekFilter}}
	        </text>

	        <text v-for="month in months" 
	        	  class="Calendar__Month"
	        	  :transform="'translate(' + month.distance + ', -10)'">
	        	{{month.label | monthFilter}}
	        </text>

	        <g v-show="showHexagonTooltip" :transform="'translate(' + (hoveredActivity.x - 100) + ', '+ (hoveredActivity.y - 30) +')'">
				<rect x="0" y="0" width="260" height="20" fill="#3f4652"></rect>
				<text x="10" y="13" font-size="11" fill="white">{{hexagonTooltipContent}}</text>
			</g>
    	</g>
        
    </svg>
    <div class="row" style="margin-left: 100px; margin-right: 100px;">
    	<span class="Calendar__Year active"><a>2016</a></span>
    	<span class="Calendar__Year"><a>2017</a></span>
    	<span class="Calendar__Year"><a>2018</a></span>

    	<div class="contrib-legend">
	    	<span>Бага</span>
	    	<ul class="legend">
	          <li style="background-color: #eee"></li>
	          <li style="background-color: #d6e685"></li>
	          <li style="background-color: #8cc665"></li>
	          <li style="background-color: #44a340"></li>
	          <li style="background-color: #1e6823"></li>
	        </ul>
	    	<span>Их</span>
    	</div>
    </div>
</template>

<script>
	import CustomHexagon from './CustomHexagon.vue';

	export default {
		props : {
			year : {	
				
			},

			data : {

			},

			userId : {
				required : true,
			}
		},

		data () {
			return {
				days : 365,
				weekCount : 52,
				hexagons : [],
				activities : [],
				length : 8,
				showHexagonTooltip : false ,
				hexagonTooltipContent : '',
				hoveredActivity : {},
				monthDistance : 60,
				weekDistance : 30,
				monthPadding : 10, 
				months : [],
				weeks : [],
			}
		},

		created : function () {
			this.getActivities()
		},

		ready : function () {
			for(var i = 0; i < 12; i ++) {
				this.months.push({
					'label' : i,
					'distance' : (i * this.monthDistance) + this.monthPadding
				})
			}

			for(var i = 1; i < 4; i ++) {
				this.weeks.push({
					'label' : i,
					'distance' : (i * this.weekDistance)
				})
			} 
		},

		filters : {
			weekFilter : function (week) {
				switch (week) {
					case 1 : 
						return this.$t('calendar.day.mon')
					case 2 : 
						return this.$t('calendar.day.wed')
					case 3 : 
						return this.$t('calendar.day.fri')
					default : 
						return this.$t('calendar.day.sun')
				}
			},

			monthFilter : function (month) {
				switch (month) {
					case 0 : 
						return this.$t('calendar.month.jan')
					case 1 : 
						return this.$t('calendar.month.feb')
					case 2 : 
						return this.$t('calendar.month.mar')
					case 3 : 
						return this.$t('calendar.month.apr')
					case 4 : 
						return this.$t('calendar.month.may')
					case 5 : 
						return this.$t('calendar.month.jun')
					case 6 : 
						return this.$t('calendar.month.jul')
					case 7 : 
						return this.$t('calendar.month.aug')
					case 8 : 
						return this.$t('calendar.month.sep')
					case 9 : 
						return this.$t('calendar.month.oct')
					case 10 : 
						return this.$t('calendar.month.nov')
					case 11 : 
						return this.$t('calendar.month.dec')
					default : 
						return this.$t('calendar.month.dec')
				}
			}
		},

		methods : {
			getActivities : function () {

				this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.userId + '/activity?year=' + this.year).then(res => {
				  	this.activities = res.data.result
				  	this.draw()
				  	
				}).catch(err => {

				});
			},

			onHexagonHover : function (activity, e) {
				this.hoveredActivity = activity

				this.hexagonTooltipContent = activity.label + '-ны өдөр '

				if(activity.duration > 0)
					this.hexagonTooltipContent += activity.duration + ' минут хичээллэсэн.'
				else 
					this.hexagonTooltipContent += 'хичээллээгүй байна.'

				this.showHexagonTooltip = true
			},

			onHexagonMouseOut : function () {
				this.showHexagonTooltip = false
			},

			onHexagonClick : function (activity) {
				this.$dispatch('_hexagonclicked', activity)
			},
			
			draw : function () {
				this.calcDays(this.year)
				this.calcWeeks(this.year)
				this.calcData()
			},

			calcDays : function (year) {
				this.days = Vue.moment((year + 1) + '-01-01').diff(Vue.moment(year + '-01-01'), 'days')
			},

			calcWeeks : function (year) {
				this.weekCount = Vue.moment(year + '-01-01').weeksInYear()
			},

			calcColor : function (duration) {
				if (duration == 0) return "#eeeeee"
				if (duration > 0 && duration < 60) return "#d6e685"
				if (duration > 60 && duration < 120) return "#8cc665"
				if (duration > 120 && duration < 180) return "#44a340"
				return "#1e6823"
			},

			calcData : function () {
				this.hexagons = []

				var start = Vue.moment(this.year + '-01-01')
				var row = start.day() == 0 ? 6 : start.day() - 1;
				var column = 0
				var items = []

				for(var i = 0; i < this.days; i ++)
				{
					if(row == 7) {
						column ++
						row = 0
					}

					var date = Vue.moment(this.year + '-01-01').add(i, 'days').format('YYYY/MM/DD');

					var activity = _.find(this.activities, function (current) {
						return Vue.moment(current.start_time).format("YYYY/MM/DD") == date
					})

					items.push({
						'x' : column * this.length * 1.7, 
						'y' : row * this.length * 2 + (column % 2 == 0 ? this.length : 0),
						'label' : date,
						'duration' : activity ? activity.duration : 0,
					})

					row ++
				}

				this.hexagons = items
			},
		},

		components : {
			CustomHexagon
		}

	}
</script>
<style lang="scss">
	.calendar-graph {
	    position: relative;
	}

	.Hexagon__tooltip {
		padding: 3px 8px; 
		white-space: nowrap;
		color: #fff;
		border-radius: 3px;
		font-size: 11px;
		position: absolute;
		pointer-events: none;
		&:after {
			content: '';
			width: 0; 
			height: 0; 
			border-left: 5px solid transparent;
			border-right: 5px solid transparent;
		  	border-top: 5px solid #3f4652;
			position: absolute;
			top: 100%;
			left: 104px;
		}
	}

	text.Calendar__Month {
	    font-size: 10px;
	    text-anchor: middle;
	    fill: #767676;
	}

	.contrib-legend {
	    float: right;
	    color: #767676 !important;
	}

	.contrib-legend span {
		font-size:  12px;
	}

	.contrib-legend .legend li {
	    display: inline-block;
	    width: 10px;
	    height: 10px;
	}

	.contrib-legend .legend {
	    position: relative;
	    bottom: -1px;
	    display: inline-block;
	    margin: 0 5px;
	    list-style: none;
	}

	.Calendar__Year {
		margin-right: 5px;
		float: left;
		padding : 3px;
		border-radius: 3px;
		background-color : #eeeeee;
	}

	.Calendar__Year.active {
		background-color: #3f4652;

		a {
			color: #eeeeee !important;
		}
	}

	.Calendar__Year a {
		color : #3f4652 !important;
		font-size: 11px;
	}
</style>