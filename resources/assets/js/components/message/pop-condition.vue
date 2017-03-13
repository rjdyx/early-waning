<template>
    <pop-form
        :rows="rows" 
        :editForm="form" 
        :edit="edit"
        @addSuccess="$emit('addSuccess')"
    ></pop-form>
</template>

<script>

    export default {
        name: 'PopCondition',
        props: {
            form: {
                type: Object,
                default() {
                    return {}
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
                rows: {
                    code: {
                        label: '预警条件编码',
                        rules: ['required', 'max:50'],
                        value: '',
                        placeholder: '必填'
                    },
                    type: {
                        label: '事件类型',
                        options: [{id: 1, name: '预警事件'}, {id: 2, name: '突发事件'}],
                        optionLabel: 'name',
                        optionValue: 'id',
                        value: '',
                        placeholder: '请选择事件类型'
                    },
                    description: {
                        label: '预警条件描述',
                        rules: ['required', 'max:50'],
                        value: '',
                        placeholder: '必填'
                    }
                }
            }
        },
        mounted () {
            this.$popForm.setFormUrl('waningcondition')
        }
    }

</script>
