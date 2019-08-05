import React from 'react';
import { Route, Redirect } from 'react-router-dom';

const AdminRoute = ({ component: Component, ...rest }) => (
    <Route {...rest} render={(props) => {
        response = localStorage.getItem("response")
        if(!response || typeof response != "object"){
            return(<Redirect to='/login' />)
        }
        var response = JSON.parse(response)
        if( response.user.roles === 'ADMIN'){
            return(<Redirect to='/admin' />)
        }
        else{
            return( <Component {...props} /> )
        }
    }} />
)


export default AdminRoute 