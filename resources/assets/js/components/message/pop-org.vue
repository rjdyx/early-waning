<template>
    <pop-form
        ref="popForm"
        :rows="rows" 
        :editForm="form" 
        :edit="edit"
        @addSuccess="$emit('addSuccess')"
    ></pop-form>
</template>

<script>

    export default {
        name: 'PopOrg',
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
                        label: '机构名称',
                        rules: ['required', 'max:50'],
                        value: '',
                        placeholder: '必填'
                    },
                    org_level_id: {
                        label: '机构类型',
                        options: [{}],
                        optionLabel: 'name',
                        optionValue: 'id',
                        value: '',
                        placeholder: '请选择机构类型'
                    },
                    address: {
                        label: '机构地址',
                        rules: ['max:50'],
                        value: ''
                    },
                    zipcode: {
                        label: '邮编',
                        rules: ['max:20'],
                        value: ''
                    },
                    phone: {
                        label: '固定电话',
                        rules: ['phone'],
                        value: ''
                    },
                    cellphone: {
                        label: '手机',
                        rules: ['cellphone'],
                        value: ''
                    },
                    fax: {
                        label: '传真',
                        rules: ['phone'],
                        value: ''
                    },
                    meno: {
                        label: '备注',
                        rules: ['max:255'],
                        value: ''
                    }
                }
            }
        },
        mounted () {
            this.getOrgLevel()
            this.$popForm.setFormUrl('org')
        },
        methods: {

            getOrgLevel () {
                axios.get(this.$adminUrl('normal-type?type=1'))
                    .then((responce) => {
                        this.$set(this.rows.org_level_id, 'options', responce.data)
                    })
            }

        }
    }

</script>
