import Vue from 'vue'
import {PopForm} from './PopForm.js'
import {popForm as protoName} from '../protoName.js'
import popForm from './component/pop-form.vue'

export default {
    install() {

    	
    	let popFormObj = new PopForm()

    	if(Vue.prototype.$popForm == undefined) {
    		Object.defineProperty(Vue.prototype, '$popForm', {
			    get () { return popFormObj }
			})
    	}
	    
	    Vue.mixin({
			data() {
		        return {
		            $popForm: popFormObj
		        }
    		},
    		computed: {
    			// 表单提交的url
    			[protoName.formUrl] () {
                    return this.$popForm.formUrl;
	            }
    		}
		})

		Vue.component('pop-form', popForm)
	}
};