/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <div>
    	<el-button @click="dialogVisible=true">{{btnName}}</el-button>
    	<el-dialog v-model="dialogVisible" size="tiny" :show-close="false" class="cus-dialog">
			<!-- dialog title -->
		  	<div slot="title" class="cus-title">{{params.title}}</div>

		  	<!-- dialog body -->
		  	<div class="cus-body">
		  		<ul>
		  			<li v-for="(data, index) in datas">
		  				<span>
		  					<el-input 
		  						v-model="editInput" 
		  						:value="data" 
		  						:class="{'data-input': true, 'data-input-border': index != editIndex}" 
		  						@focus="edit(data, index)"
		  						@blur="editIndex=-1"
		  						placeholder="请输入内容">
	  						</el-input>
	  					</span>
		  				<span>
			  				<i class="el-icon-close" @click="delete(data, index)"></i>
		  				</span>
		  			</li>
		  		</ul>
		  		<el-button 
		  			v-if="!showNewModel" 
		  			icon="plus" 
		  			class="new-btn" 
		  			@click="showNewModel=true">新建</el-button>
		  		<el-input 
		  			v-else 
		  			v-model="newInput"
		  			:autofocus="true"
		  			@blur="showNewModel=false" 
		  			placeholder="最多20个字" 
		  			class="new-input">
				    <el-button slot="append" @click="showNewModel=false">新建</el-button>
				 </el-input>
		  	</div>

		  	<!-- dialog footer -->
		  	<div slot="footer" class="dialog-footer">
		    	<el-button @click="dialogVisible = false">取 消</el-button>
		    	<el-button type="primary" @click="dialogVisible = false">确 定</el-button>
		  	</div>
		</el-dialog>
    </div>
</template>

<style lang="sass">
    @import "../../../sass/function";
	.cus-dialog {
		line-height: initial;

		&>div.el-dialog {
			width: 20%;
		}

		.cus-title {
			text-align: center;
			border-bottom: 1px solid #9E9E9E;
    		padding-bottom: pxToRem(20);
		}

		.cus-body {
			width: 90%;
			margin: auto;

			ul {
				height: pxToRem(150);
			    overflow-y: auto;
			    overflow-x: hidden;

				li {
					padding: pxToRem(6) 0;
					
					span:nth-child(1) {
						
						.data-input {
							width: 72%;
							
						}

						.data-input-border {
							input[type=text] {
							    border: 1px solid white;
							}
						}
					}

					span:nth-child(2) {
						float: right;
						height: pxToRem(36);
    					line-height: pxToRem(36);

						i {
							margin: 0 pxToRem(10);
    						cursor: pointer;
						}
					}
				}
			}

			.new-btn {
			    display: inline-block;
			    width: 100%;
			    text-align: left;
			    color: #9E9E9E;
			    margin-top: pxToRem(17);
			}

			.new-input {
				margin-top: pxToRem(17);
			}
		}

		.dialog-footer {
    		text-align: center;
		}
	}
</style>

<script>

    export default{
        name:'TypeManage',
        props: {
        	btnName: {
        		type: String,
        		default: '机构类型管理'
        	},
        	params: {
        		type: Object,
        		default () {
        			return {
        				title: '机构类型管理'
        			}
        		}
        	}
        },
        data () {
        	return {
        		dialogVisible: false,
        		datas: ['总局', '直属局', '分局口岸'],
        		// 编辑输入框的值
        		editInput: '',
        		// 某个编辑框的下标
        		editIndex: -1,
        		// 新增输入框的值
        		newInput: '',
        		// 是否显示新增模块
        		showNewModel: false
        	}
        },
        methods: {
        	edit (data, index) {
        		this.editInput = data;
        		this.editIndex = index;
        	},

        	delete () {

        	}
        }
    }

</script>
