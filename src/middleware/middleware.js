import React from 'react';
import { Route, Redirect } from 'react-router-dom';
import { log } from 'util';

const AdminRoute = ({ component: Component, ...rest }) => (
    <Route {...rest} render={(props) => {
       var response = localStorage.getItem("user")
        if(!response){
            return(<Redirect to='/login' />)
        }
        var response = JSON.parse(response)
        if( response.user.roles === 'ADMIN'){
            return( <Component {...props} /> )
        }
    }} />
)


export default AdminRoute 