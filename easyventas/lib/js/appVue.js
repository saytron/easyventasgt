button.addEventListener('click', () =>{
    axios({
      method: 'POST',
      url: 'http://agromar.com.gt/easyventasgt/Controller/cargarProducto.php'

    }).then(res => {
      console.log(res.data)
    }).catch(err => console.log(err))
  })