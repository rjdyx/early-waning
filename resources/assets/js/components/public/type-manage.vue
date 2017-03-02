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
    	<el-button @click="openDialog">{{params.title}}</el-button>
    	<el-dialog 
    		v-model="dialogVisible" 
    		size="tiny" 
    		:show-close="false" 
    		:lock-scroll="true"
    		@close="closeDialog" 
    		class="cus-dialog">
			<!-- dialog title -->
		  	<div slot="title" class="cus-title">{{params.title}}</div>

		  	<!-- dialog body -->
		  	<div class="cus-body">
                <vue-perfect-scrollbar class="cus-body-ul" :settings="settings">
    		  		<ul>
    		  			<li v-for="(data, index) in datas">
    		  				<span>
    		  					<el-input 
    		  						v-model="data.name" 
    		  						:class="{'data-input': true, 'data-input-border': index != editIndex}" 
    		  						@focus="focusType(data, index)"
    		  						placeholder="请输入内容">
    	  						</el-input>
    	  					</span>
    		  				<span>
    			  				<i v-if="index == editIndex" class="el-icon-check" @click="editType(data)"></i>
    			  				<i class="el-icon-close" @click="deleteType(data, index)"></i>
    		  				</span>
    		  			</li>
    		  		</ul>
                </vue-perfect-scrollbar>
		  		<el-button 
		  			v-if="!showNewModel" 
		  			icon="plus" 
		  			class="new-btn" 
		  			@click="showNewModel=true">新建</el-button>
		  		<el-input 
		  			v-else 
		  			v-model="newInput"
		  			:autofocus="true"
		  			placeholder="最多20个字" 
		  			class="new-input">
				    <el-button slot="append" @click="addType">新建</el-button>
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
			width: 25%;
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

    .cus-body-ul {
        position: relative;
        height: pxToRem(150);
    }
</style>

<script>


    export default{
        name:'TypeManage',
        props: {
        	params: {
        		type: Object,
        		default () {
        			return {
        				title: '机构类型管理',
        				type: 1
        			}
        		}
        	},
        },
        data () {
        	return {
        		dialogVisible: false,
        		datas: [],
        		// 临时保存原先的值
        		originValue: '',
        		// 某个编辑框的下标
        		editIndex: -1,
        		// 新增输入框的值
        		newInput: '',
        		// 是否显示新增模块
        		showNewModel: false,
                // 滚动条配置
                settings: {
                    wheelSpeed: 0.2
                }
        	}
        },
        methods: {

        	/**
        	 * 打开弹窗
        	 */
        	openDialog () {
        		this.dialogVisible = true
				axios.get(this.$adminUrl('normal-type') + '?type=' + this.params.type)
	        	.then((response) => {
	        		this.$set(this, 'datas', response.data)
	        	})
        	},

        	/**
        	 * 新增
        	 */
        	addType () {
        		if(this.newInput.length == 0) {
        			return this.$message({
				          message: '必填',
				          type: 'error'
			        })
        		}
        		if(this.newInput.length > 20) {
        			return this.$message({
				          message: '最多20个字',
				          type: 'error'
			        })
        		}
        		this.showNewModel=false;
        		axios.post(this.$adminUrl('normal-type'), {
        			name: this.newInput,
        			type: this.params.type})
        		.then((response) => {
        			this.datas.push({id: response.data, name: this.newInput})
        			this.newInput = ''
                    this.$message({
                      message: '新增成功',
                      type: 'success'
                    })
        		})
        	},

        	/**
        	 * 获取编辑焦点
        	 */
        	focusType (data, index) {
        		this.editIndex = index
        		this.originValue = data.name
        	},

        	/**
        	 * 编辑
        	 */
        	editType (data) {
        		this.editIndex = -1
        		if(data.name.length == 0) {
        			return this.$message({
				          message: '必填',
				          type: 'error'
			        })
        		}
        		if(data.name.length > 20) {
        			return this.$message({
				          message: '最多20个字',
				          type: 'error'
			        })
        		}
        		if(this.originValue == data.name) {
        			return this.$message('无修改')
        		}
        		axios.put(this.$adminUrl('normal-type/') + data.id, {
        			name: data.name})
        		.then((response) => {
        			if(response.data) {
        				this.$message({
				          message: '修改成功',
				          type: 'success'
				        })
        			}else {
        				this.$message(response.data)
        			}
        		})
        	},

        	deleteType (data, index) {
        		axios.delete(this.$adminUrl('normal-type/') + data.id)
        		.then((response) => {
        			if(response.data !== 'been used!') {
        				this.$message({
				          message: '删除成功',
				          type: 'success'
				        });
				        this.datas.splice(index, 1)
        			}else {
        				this.$message('被使用，无法删除')
        			}
        		})
        	},

        	/**
        	 * 关闭弹窗
        	 */
        	closeDialog () {
        		this.$set(this, 'datas' , [])
        		this.editIndex = -1
        		this.newInput = ''
        		this.showNewModel = false
        	}
        }
    }

</script>
