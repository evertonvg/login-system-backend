require('./bootstrap');

(async() =>{
	await axios.get('/sanctum/csrf-cookie').then((resp)=>{
		console.log(resp)
	})

	await axios.get('/login').then((resp)=>{
		console.log(resp)
	})


	await axios.get('/users').then((res)=>{
		console.log(res)
	});

	await axios.get('/api/user').then((res)=>{
		console.log(res)
	});
	// await axios.get('/logout').then((res)=>{
	// 	console.log(res)
	// });


})()



