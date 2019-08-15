import React, { useState } from "react";
import { FormInputs } from "components/FormInputs/FormInputs.jsx";
import Button from "components/CustomButton/CustomButton.jsx";
import Card from "components/Card/Card.jsx";
import {
  Grid,
  Row,
  Col
} from 'react-bootstrap';
import { Redirect } from 'react-router-dom';
import axios from 'axios';

import Api from '../config/Api';

export default function Login () {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [redirect, setRedirect] = useState(false);

  const HandleSubmit = (e) => {
    e.preventDefault();
    axios.post(Api.url(`/auth/login`), {
      email: email,
      password: password
    }).then(response => {
      if (response.data.user.roles === "ADMIN") {
        localStorage.setItem('token', response.data.access_token.token);
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
    <div style={LoginStyle}>
      <Grid>
        <Row>
          <Col md={12}>
            <Card
              title="Login"
              content={
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
              }
              />
          </Col>
        </Row>
      </Grid>
    </div>
  );
}

const LoginStyle = {
  height: '100vh',
  display: 'flex',
  alignItems: 'center',
  justifyContent: 'center',
  // background: 'rgb(251,186,0)',
  background: 'linear-gradient(45deg, rgba(251,186,0,1) 0%, rgba(148,142,141,1) 50%, rgba(0,212,255,1) 100%)'
}
