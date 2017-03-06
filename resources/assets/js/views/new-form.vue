<template>
    <div>
        <div class="top">
            <el-button icon="arrow-left" @click="$router.back()">返回</el-button>
            <div class="title">{{title}}</div>
            <div v-if="!edit" class="status-btns">
                <ul>
                    <li>
                        提交后重置
                        <el-switch
                          v-model="reset"
                          on-text=""
                          off-text="">
                    </li>
                    <li>
                        提交后不返回
                        <el-switch
                          v-model="back"
                          on-text=""
                          off-text="">
                    </li>
                    
                </ul>
            </div>
        </div>
        <vue-perfect-scrollbar class="middle">
            <component v-if="edit" :is="popComponent" :form="formMsg" :edit="edit"></component>
            <component v-else :is="popComponent" :edit="edit" @addSuccess="addSuccess" ref="formPop"></component>
        </vue-perfect-scrollbar>
    </div>
    
</template>

<style lang="sass" scoped>
    @import "../../sass/function";

    .top {
        position: absolute;
        top: pxToRem(48);
        right: 0;
        width: 100%;
        height: pxToRem(48);
        line-height: pxToRem(48);
        z-index: 100;
        border-bottom: 1px solid #d9d9d9;
        background: white;

        button {
            margin-left: pxToRem(190);
        }

        .title {
            display: inline-block;
            margin-left: pxToRem(30);
        }

        .status-btns {
            float: right;
            margin-right: pxToRem(30);

            ul {

                li {
                    float: right;
                    margin-right: pxToRem(30);
                }
            }
        }
    }
</style>

<script>

    import {mapState, mapMutations} from 'vuex'
    import PopOrg from 'components/message/pop-org.vue'
    import PopExpert from 'components/message/pop-expert.vue'
    import PopEmergencyCrew from 'components/message/pop-emergencycrew.vue'
    import PopPlan from 'components/message/pop-plan.vue'
    import PopInformation from 'components/message/pop-information.vue'

    export default {
        name: 'NewForm',
        props: {
            title: {
                type: String,
                default: '新增'
            }
        },
        data () {
            return {
                popComponent: null,
                // 提交后是否返回
                back: false,
                // 提交后是否重置表单
                reset: false
            }
        },
        computed: {

            ...mapState([
                'formMsg'
            ]),

            model () {
                return this.$route.params.model
            },
            edit () {
                return this.$route.params.type === 'edit'?true:false
            }
        },
        mounted () {
            
            switch(this.model) {
                case 'org':
                    this.popComponent = PopOrg
                    break
                case 'expert':
                    this.popComponent = PopExpert
                    break
                case 'emergencycrew':
                    this.popComponent = PopEmergencyCrew
                    break
                case 'plan':
                    this.popComponent = PopPlan
                    break
                case 'information':
                    this.popComponent = PopInformation
                    break
            }
        },
        methods: {
            ...mapMutations([
                'setFormMsg'
            ]),

            addSuccess () {
                if(!this.back){
                    this.$router.back()
                }
                if(this.reset){
                    $('.form-pop')[0].reset()
                }
            }
        },
        destroyed () {
            this.setFormMsg(null)
        }
    }

</script>
