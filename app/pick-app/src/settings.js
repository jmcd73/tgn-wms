const settings = {
	url: 'http://localhost:8081/wms'
}

const dlog = (msg = '') => {

	if(process.env.NODE_ENV === 'development') {

		console.log(msg);
	}
}

export default settings
