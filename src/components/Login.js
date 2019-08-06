import React, {
  Component
} from 'react';
import Button from 'components/CustomButton/CustomButton';
import FormInputs from 'components/FormInputs/FormInputs';
import {
  Row,
  Col
} from "react-bootstrap";
import { withRouter } from 'react-router'

class Login extends Component {

  constructor(props) {
    super(props);
    this.state = {
      email: '',
      password: '',
      error: ''
    }
  }

  handleSubmit = (event) => {
    event.preventDefault();
    fetch("http://localhost:3333/v1/auth/login", {
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        method: 'POST',
        body: JSON.stringify({
          email: this.state.email,
          password: this.state.password
        }),
      }).then(response => response.json())
      .then(
        response => {
          if(response.status){
            console.log(response)
            this.setState({"error": "Veuillez entrer un e-mail ou mot de passe valide."})
          } else {
            localStorage.setItem("user", JSON.stringify(response))
            this.props.history.push("/admin");
          }
        })
  }

  handleChange = (event) => {
    this.setState({
      [event.target.id]: event.target.value
    })
  }

  render() {
    return ( 
    <div>
      <h1> Hello </h1> 
        <Row>
            <Col md = {6} >
                <form onSubmit = {this.handleSubmit} >
                <span><small style={{ color : "red" }}>{this.state.error}</small></span>
                    <FormInputs ncols = {["col-md-6", "col-md-5", ]}
                                properties = {[
                                    {
                                        label: "Email address",
                                        type: "email",
                                        bsClass: "form-control",
                                        placeholder: "Email",
                                        id: "email",
                                        onChange: this.handleChange
                                    },
                                    {
                                        label: "Password",
                                        type: "password",
                                        bsClass: "form-control",
                                        placeholder: "Password",
                                        id: "password",
                                        onChange: this.handleChange
                                    }
                                ]}

                                /> 
                    <Button type = "submit" bsStyle = "success"> Submit </Button>         
                </form> 
            </Col> 
        </Row> 
    </div>
    )
  }
}

export default withRouter(Login)