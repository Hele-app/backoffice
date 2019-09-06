const NODE_ENV = process.env.NODE_ENV ? process.env.NODE_ENV : 'development';

const Api = {
    // doit finir par un '/'
    VERSION: 'v1/',
    // doit finir par un '/'
    BASE_URL: NODE_ENV === 'production' ? 'https://api.hélé.fr/' : 'http://localhost:3333/',

    url: function(route = '/') {
	return this.BASE_URL + this.VERSION + route.replace(new RegExp('^[/]+'), '');
    }
};

export default Api;
