
export class PopForm {

	constructor () {
		this.formUrl = ''
	}

	setFormUrl(formUrl) {
		this.formUrl = formUrl
	}

    * beforeFn(fn) {
        yield fn()
    }

    * afterAddFn(fn) {
        yield fn()
    }

    * afterEditFn(fn) {
        yield fn()
    }

}
