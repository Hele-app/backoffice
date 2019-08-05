import React from 'react';
import { Route, Redirect } from 'react-router-dom';

const Authentication = ({ component: Component, ...props }) => {
  return (
    <Route
      {...props}
      render={innerProps => {
          let token = localStorage.getItem("token");
	  let user = localStorage.getItem("user");
          if (!token || !user) {
	      return (<Redirect to="/login" />);
	  } else {
	      return (<Component {...innerProps} />);
	  }
      }}/>
  );
};

export default Authentication;
