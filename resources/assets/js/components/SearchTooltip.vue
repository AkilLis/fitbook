<template>
	<div class="search-tooltip" v-show="hover">
		<div class="row">	
			<div class="small-4 column" style="height: 70px; background-image: url('../images/flexgym/08.jpg'); background-size: 100% 100%; background-repeat: no-repeat;">
			</div>
			<div class="small-8 column" style="padding:5px">
				<label style="text-align: center;">{{club.short_name}}</label>
				<div style="text-align: center;">
				  <i class="star-1" style="color:#f26a2c;">★</i>
				  <i class="star-2" style="color:#f26a2c;">★</i>
				  <i class="star-3" style="color:#f26a2c;">★</i>
				  <i class="star-4" style="color:#f26a2c;">★</i>
				  <i class="star-5" style="color:#aeaeae;">★</i>
				</div>
				{{club.address}}
				<div style="font-size:10px; text-align:center;">Дэлгэрэнгүй ... <i style="text-decoration:underline;">/Товших/ </i></div>
			<div>
		</div>
	<div>
</template>

<script>
	export default {
		props: {
			hover : { default: false },
			club : {default: null},
		},
	}
</script>
	
<style>
	button:focus {outline:0;}

	#omnibox {
	    position: absolute;
	    left: 0px;
	    margin: 16px;
	    top: 0px;
	    z-index: 10;
	    transition: left 0.5s;
	    -webkit-transform: translateX(0px);
	    transform: translateX(0px);
	    transition-property: -webkit-transform,transform,visibility,opacity;
	    transition-duration: 200ms;
	    transition-timing-function: cubic-bezier(0.0,0.0,0.2,1);
	}

	.vasquette-margin-enabled#rap-card, .vasquette-margin-enabled#omnibox {
	    margin: 8px 0 8px 8px;
	}

	.searchbox.suggestions-shown 
	{
	    border-radius: 2px 2px 0 0;
	}

	.searchbox-shadow 
	{
	    box-shadow: 0 2px 4px rgba(0,0,0,0.2),0 -1px 0px rgba(0,0,0,0.02);
	}

	.searchbox 
	{

	    position: relative;
	    background: #fff;
	    border-radius: 2px;
	    box-sizing: border-box;
	    height: 48px;
	    border-bottom: 1px solid transparent;
	    padding: 12px 104px 11px 64px;
	    transition-property: background,box-shadow;
	    transition-duration: 0.3s;
	}

	.searchbox-searchbutton-container 
	{
	    position: absolute;
	    right: 54px;
	    top: 0;
	}

	.searchbox-findme
	{
	    position: absolute;
	    right: 0px;
	    top: 0;
	}

	.searchbox-searchbutton::before {
	    content: '';
	    display: block;
	    width: 24px;
	    height: 24px;
	    background: url(//maps.gstatic.com/tactile/omnibox/quantum_search_button-20150825-1x.png);
	    background-size: 72px 24px;
	}

	.searchbox-searchbutton-container::after {
	    content: "";
	    position: absolute;
	    right: 0;
	    top: 10px;
	    border-left: 1px solid #ddd;
	    height: 28px;
	}

	.searchbox-searchbutton {
	    display: block;
	    padding: 12px 15px;
	}

	.searchbox-input {
	    border: none; 
	    padding: 0px; 
	    margin: 0px; 
	    height: auto; 
	    width: 100%; 
	    z-index: 6;
	    left: 0px;
	    outline: none;
	    font-size: 15px;
	}

	.searchbox-hamburger::before {
	    content: '';
	    display: block;
	    background-image: url(//maps.gstatic.com/tactile/omnibox/quantum_menu-v2-1x.png);
	    background-size: 48px 24px;
	    background-position: 0 0;
	    height: 24px;
	    width: 24px;
	    opacity: .62;
	}

	.searchbox-hamburger {
	    display: block;
	    cursor: pointer;
	    padding: 12px 16px;
	}

	.searchbox-hamburger-container 
	{
	    position: absolute;
	    z-index: 1003;
	    left: 0;
	    top: 0;
	}

	/* Pin Hover Box Styles */
	.search-tooltip{
		z-index: 11;
	    position: absolute;
	    background-color: #FFFFFF;
	    width: 250px;
	    height: 70px;
	    -webkit-box-shadow: 10px 10px 30px 0px rgba(174,174,174,1);
	    -moz-box-shadow: 10px 10px 30px 0px rgba(174,174,174,1);
	    box-shadow: 10px 10px 30px 0px rgba(174,174,174,1);
	    border-radius: 5px;
	}

	.rating {
	  margin: 10px 0;
	}

	.rating i {
	  display: inline-block;
	  width: 0;
	  height: 1.5em;
	  border-width: 1.5em / 2;
	  border-style: solid;
	  border-color: #eee;
	  border-radius: .22em;
	  color: white;
	  background: #eee;
	  font-style: normal;
	  line-height: 1.6em;
	  text-indent: -0.5em;
	  text-shadow: 1px 0 1px hsl(0, 0%, 70%);
	}
	/*panel*/
	.pane {
	    /*position: relative;*/
	    display: block;
	}

	.pane-holder{
	    width: 408px;
	    height: 100%;
	    position: absolute;
	    z-index: 2;
	    left: 0;
	    top: 0;
	    overflow: hidden;
	}

	.pane-holder:hover{
	    overflow-y: scroll;
	}

	.pane-header{
	    width: 100%;
	    height: 256px;
	    background-color: #fff;
	}
	.pane-content{
	    width: 100%;
	    height: auto;
	    line-height: 1.5em;
	    background-color: #4285F4;
	    padding: 10px;
	    color: #fff;
	}
	.pane-content h1{
	    font-size: 25px;
	}
	.pane-holder-small{
	    overflow-y: scroll;
	}

	.find-mylocation{
	    display: block;
	    padding: 12px 15px;
	}

	.reset-button{
	    display: block;
	    padding: 12px 15px;
	}
	.reset-button::before{
	    background-image: url(//maps.gstatic.com/tactile/omnibox/clear-1x-20150504.png);
	    background-size: 96px 24px;
	    height: 24px;
	    width: 24px;
	    cursor: pointer;
	    display: block;
	    content: '';
	}

</style>