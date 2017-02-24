/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <div id="main">
    </div>
</template>

<style lang="sass" scoped>
    @import "../../sass/function";
    #main {
    	width: pxToRem(600);
    	height: pxToRem(400);
    }
</style>

<script>

    export default{
        name:'Index',
        mounted () {
        	// 基于准备好的dom，初始化echarts实例
			var myChart = echarts.init(document.getElementById('main'));
			// 绘制图表
			myChart.setOption({
			    title: { text: 'ECharts 入门示例' },
			    tooltip: {},
			    xAxis: {
			        data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]
			    },
			    yAxis: {},
			    series: [{
			        name: '销量',
			        type: 'bar',
			        data: [5, 20, 36, 10, 10, 20]
			    }]
			});
        }
    }

</script>
