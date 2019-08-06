import React, { useState } from "react";
import { FormInputs } from "components/FormInputs/FormInputs.jsx";
import Button from "components/CustomButton/CustomButton.jsx";
import { Redirect } from 'react-router-dom';
import axios from 'axios';

export default function Login () {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [redirect, setRedirect] = useState(false);

    const HandleSubmit = (e) => {
	e.preventDefault();
	axios.post('http://localhost:3333/v1/auth/login', {
	    email: email,
	    password: password
	}).then(response => {
	    if (response.data.user.roles === "ADMIN") {
	    	localStorage.setItem('token', JSON.stringify(response.data.access_token));
	    	localStorage.setItem('user', JSON.stringify(response.data.user));
	    	setRedirect(!redirect);
	    }
	    else {
	    	alert("You are not an administrator, you can not logged in");
	    }
	}).catch(error => {
	    alert("Invalid credentials");
	});
    };

    if (localStorage.getItem("token")) {
        return(<Redirect to='/' />);
    }
    return (
        <form onSubmit={HandleSubmit}>
          <FormInputs
            ncols={["col-md-6"]}
            properties={[
                {
                    label: "Email",
                    type: "email",
                    bsClass: "form-control",
                    placeholder: "email",
		    onChange: e => setEmail(e.target.value)
                }
            ]}
            />

            <FormInputs
              ncols={["col-md-6"]}
              properties={[
                  {
                      label: "Password",
                      type: "password",
                      bsClass: "form-control",
                      placeholder: "password",
		      onChange: e => setPassword(e.target.value)

                  }
              ]}
              />
              <Button bsStyle="info" pullRight fill type="submit">
		Login
              </Button>
              <div className="clearfix" />
        </form>
    );
}
