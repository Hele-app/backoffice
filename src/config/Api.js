const Api = {
  VERSION: 'v1/', // doit finir par un '/'
  BASE_URL: 'https://api.hélé.fr/', // doit finir par un '/'

  url: function(route = '/') {
    console.log(this.BASE_URL + this.VERSION + route.replace(new RegExp('^[/]+'), ''))
    return this.BASE_URL + this.VERSION + route.replace(new RegExp('^[/]+'), '');
  }
};

export default Api;
