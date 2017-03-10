<template>
    <form @submit.prevent="validateBeforeSubmit" class="form-pop">

        <table class="form-table">
            <tbody class="form-body">

                <tr>
                    <td class="form-label">
                        <label for="event_level_id">事件等级</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <el-select v-model="form.event_level_id" placeholder="请选择事件等级">
                            <el-option 
                                v-for="eventLevel in eventLevels" 
                                :label="eventLevel.name" 
                                :value="eventLevel.id">
                            </el-option>
                        </el-select>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="event_sort_id">事件类别</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <el-select v-model="form.event_sort_id" placeholder="请选择事件类别">
                            <el-option 
                                v-for="eventSort in eventSorts" 
                                :label="eventSort.name" 
                                :value="eventSort.id">
                            </el-option>
                        </el-select>
                    </td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="name">事件名称</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.name" 
                        v-validate.initial="form.name" 
                        data-vv-rules="required|max:50" 
                        data-vv-as="事件名称" 
                        type="text" id="name" class="el-input__inner" name="name" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="verrors.has('name')" class="error">
                    <td colspan="3">{{ verrors.first('name') }}</td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="location">发生地区</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.location" 
                        v-validate.initial="form.location" 
                        data-vv-rules="required|max:50" 
                        data-vv-as="发生地区" 
                        type="text" id="location" class="el-input__inner" name="location" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="verrors.has('location')" class="error">
                    <td colspan="3">{{ verrors.first('location') }}</td>
                </tr>

                <tr>
                    <td class="form-label">
                        <label for="detail">事件详情</label>
                    </td>
                    <td class="form-input" colspan="2">
                        <input 
                        v-model="form.detail" 
                        v-validate.initial="form.detail" 
                        data-vv-rules="required" 
                        data-vv-as="事件详情" 
                        type="text" id="detail" class="el-input__inner" name="detail" placeholder="必填">
                    </td>
                </tr>

                <tr v-show="verrors.has('detail')" class="error">
                    <td colspan="3">{{ verrors.first('detail') }}</td>
                </tr>
               
            </tbody>

            <tfoot class="form-footer">
                <tr>
                    <td colspan="3">
                        <el-button @click="cancel">取 消</el-button>
                        <el-button type="primary" native-type="submit">确 定</el-button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</template>

<script>

    export default {
        name: 'PopEvent',
        props: {
            form: {
                type: Object,
                default() {
                    return {
                        id: '',
                        name: '',
                        location: '',
                        detail: '',
                        status: 1,
                        event_level_id: 0,
                        event_sort_id: 0
                    }
                }
            },
            // 表示此模块是编辑模块还是新增模块的标志
            edit: {
                type: Boolean,
                default: false
            },
        },
        data () {
            return {
                // 作为编辑组件时，用于临时备份父组件传递过来的数据，
                // 以便在修改了数据但不保存时可以复原数据
                tmp: {
                    id: '',
                    name: '',
                    location: '',
                    detail: '',
                    status: 1,
                    event_level_id: 0,
                    event_sort_id: 0
                },
                // 事件等级
                eventLevels: [],
                // 事件类别
                eventSorts: []
            }
        },
        mounted () {
            for(let key of Object.keys(this.form)){
                this.tmp[key] = this.form[key]
            }
            this.getEventLevel()
            this.getEventSort()
            this.form.status = this.$route.params.model.split('-')[1]
        },
        methods: {

            getEventLevel () {
                axios.get(this.$adminUrl('normal-type?type=5'))
                    .then((responce) => {
                        this.$set(this, 'eventLevels', responce.data)
                        if(!(this.form.event_level_id))this.form.event_level_id = this.eventLevels[0].id
                    })
            },

            getEventSort () {
                axios.get(this.$adminUrl('normal-type?type=6'))
                    .then((responce) => {
                        this.$set(this, 'eventSorts', responce.data)
                        if(!(this.form.event_sort_id))this.form.event_sort_id = this.eventSorts[0].id
                    })
            },

            /**
            * 提交表单
            */
            validateBeforeSubmit () {

                // 验证表单
                this.$validator.validateAll()
                // 如果表单报错则不提交
                if(this.verrors.any()) {
                    return false
                }else {

                    this.form = this.$filterObj(this.form)

                    if(this.edit) {
                        axios.put(this.$adminUrl('event/') + this.form.id, this.form)
                        .then((responce) => {
                            if(responce.data) {
                                this.$message({
                                  message: '修改成功',
                                  type: 'success'
                                })
                                this.$router.back()
                            }
                        })
                    }else {
                        axios.post(this.$adminUrl('event'), this.form)
                        .then((responce) => {
                            if(responce.data) {
                                this.$message({
                                  message: '新增成功',
                                  type: 'success'
                                })
                                this.$emit('addSuccess')
                            }
                        })
                    }
                    
                }
                
            },

            cancel () {
                this.$router.back()
            }

        },
        destroyed () {
            if(this.edit){
                for(let key of Object.keys(this.form)){
                    this.form[key] = this.tmp[key];
                }
            }
        },
    }

</script>
