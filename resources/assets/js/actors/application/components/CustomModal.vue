<template>
<div class="modal-mask" @click="modalDisapear" v-if="show" transition="modal">
        <div class="modal-container autoscroll" @click.stop>
            <div class="modal-header">
				<slot name="header">
					<div class="row small-up-3 medium-up-3 large-up-3">
					  <div class="columns">
					  	<button @click="modalClose" class="close-button" type="button">
							<span class="fa fa-times" aria-hidden="true"></span>
						</button>
					  </div>
					  <div class="columns">
					  	<button v-show="saveCallback" @click="modalSave" class="save-button" type="button">
					    	<span aria-hidden="true" class="fa fa-check"></span>
					    </button>
					  </div>
					</div>	
					<div class="row" style="height:50px; text-align: center;">
						<h4 style="color:#5fcf80;">{{title}}</h4>
					</div>
				</slot>
			</div>


			<div v-show="loading" class="modal-loader">

				<div class="preloader-wrapper small active">
	              <div class="spinner-layer spinner-green-only">
	                <div class="circle-clipper left">
	                  <div class="circle"></div>
	                </div><div class="gap-patch">
	                  <div class="circle"></div>
	                </div><div class="circle-clipper right">
	                  <div class="circle"></div>
	                </div>
	              </div>
	            </div>

			</div>

            <div v-show="!loading" class="modal-body">
	          <slot name="body">
	          	<component v-if="type == 'Club'" 
	          			   :id="id" 
	          			   :type="type" 
	          			   :is="context">
				</component>
				<components :multiple="multiple"
							v-else 
							:is="context">
				</components>
	          </slot>
	        </div>

            <div class="modal-footer">
	          <slot name="footer">
	          </slot>
	        </div>
        </div>
    </div>
</template>

<script>

	export default {
		props: {
			id : {},
			type : {default : 'Club'},
			multiple : {},
			title : { default: '' },
			loading : { 
				type : Boolean,
				default : false 
			},
			title_en : {default : ''},
			usage : { default: 'questionable'},
			context : {},
			saveCallback : { default: null },
			validateable : { 
				default: 'N'
			},
			disapearable : {
				default : true,
			},
			show: {
		      type: Boolean,
		      required: true,
		      twoWay: true,
		      default : false,    
		    },
		    zIndex : {
		    	default: 1006,
		    },
		},

		created : function () {

		},

		methods : {

			modalDisapear: function () {
				if(this.disapearable)
					this.modalClose()
			},

			modalClose : function () {
				this.show = false
			},

			modalSave : function() {
				if(this.saveCallback) {
					if(this.validateable == 'Y' && !this.$children[0].validate()){
						return;
					}

					var response = {
						id: this.usage, 
						data: this.$children[0].getData(),
					};

					this.$dispatch(this.saveCallback, response);
				}
				else
					this.modalClose();
			},
		},

		events : {
			'startLoading' : function() {
				this.loading = true;
			},

			'stopLoading' : function() {
				this.loading = false;
			},
		},

		components : {

		}
	}
</script>
<style lang="scss">
	* {
    box-sizing: border-box;
	}

	.modal-mask {
	    position: fixed;
	    z-index: 9998;
	    top: 0;
	    left: 0;
	    width: 100%;
	    height: 100%;
	    background-color: rgba(0, 0, 0, .5);
	    transition: opacity .3s ease;
	}

	.modal-container {
		display: block;
	    z-index: 1006;
	    background-color: #fefefe;
	    border-radius: 4px;
	    position: relative;
	    top: 0px;
	    height: 100%;
	    margin-left: auto;
	    margin-right: auto;
	    overflow-y: auto;
	}

	.modal-header h3 {
	    margin-top: 0;
	    color: #42b983;
	}

	.modal-loader {
		z-index: 1009;
		background-color: #fff;
		height: 100%;
		width: 100%;
	}

	.modal-body {
	    
	}

	.text-right {
	    text-align: right;
	}

	.form-label {
	    display: block;
	    margin-bottom: 1em;
	}

	.form-label > .form-control {
	    margin-top: 0.5em;
	}

	.form-control {
	    display: block;
	    width: 100%;
	    padding: 0.5em 1em;
	    line-height: 1.5;
	    border: 1px solid #ddd;
	}

	.modal-enter, .modal-leave {
	    opacity: 0;
	}

	.modal-enter .modal-container,
	.modal-leave .modal-container {
	    transition: all .3s ease;
	}

	@media screen and (min-width: 640px) {
		.modal-container {
		    width: 600px;
		    max-width: 75rem;
		    top: 50px;
		}
	}
</style>