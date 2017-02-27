/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <div id="head">
		<h1 id="title">预警</h1>
		<div id="content">
			<ul>
				<li>总览</li>
			</ul>
		</div>
    </div>
</template>

<style lang="sass" scoped>
    @import "../../../sass/function";
	
	#head {
		position: absolute;
	    top: 0;
	    left: 0;
	    height: 3rem;
	    width: 100%;
		height: pxToRem(48);
		font-size: pxToRem(14);
	    background-color: #2F3847;
	    color: white;
        z-index: 10;

		#title {
		    float: left;
		    height: pxToRem(48);
		    line-height: pxToRem(48);
		    width: 100px;
		    text-align: center;
		    font-size: 20px;
		}

		#content {
		    height: pxToRem(48);
    		line-height: pxToRem(48);

    		ul {
			    float: left;
    			// margin-left: 39px;

    			li {
				    width: pxToRem(85);
					text-align: center;
    			}
    		}
		}
	}
</style>

<script>

    export default{
        name:'MyHeader'
    }

</script>
