<template>
    <pop-form
        :rows="rows" 
        :editForm="form" 
        :edit="edit"
        @addSuccess="$emit('addSuccess')"
    ></pop-form>
</template>

<script>

    import Textarea from 'components/public/textarea.vue'

    export default {
        name: 'PopInformation',
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
                    name: {
                        label: '专题名称',
                        rules: ['required', 'max:50'],
                        value: '',
                        placeholder: '必填'
                    },
                    information_type_id: {
                        label: '专题类型',
                        options: [{}],
                        optionLabel: 'name',
                        optionValue: 'id',
                        value: '',
                        placeholder: '请选择专题类型'
                    },
                    content: {
                        label: '内容',
                        component: Textarea,
                        value: ''
                    }
                }
            }
        },
        mounted () {
            this.getinformationLevel()
            this.$popForm.setFormUrl('information')
        },
        methods: {

            getinformationLevel () {
                axios.get(this.$adminUrl('normal-type?type=4'))
                    .then((responce) => {
                        this.$set(this.rows.information_type_id, 'options', responce.data)
                    })
            }

        }
    }

</script>
