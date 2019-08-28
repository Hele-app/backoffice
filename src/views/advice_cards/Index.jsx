/*!

=========================================================
* Light Bootstrap Dashboard React - v1.3.0
=========================================================

* Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard-react
* Copyright 2019 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard-react/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/
import React, { Component } from "react";
import {
  Grid,
  Row,
  Col,
  FormGroup,
  ControlLabel,
  FormControl
} from "react-bootstrap";
import { Link} from "react-router-dom";
import { Card } from "components/Card/Card.jsx";
import { FormInputs } from "components/FormInputs/FormInputs.jsx";
import Button from "components/CustomButton/CustomButton.jsx";
import axios from 'axios';
import { Redirect } from 'react-router'

import Api from '../../config/Api';

class IndexAdviceCards extends Component {

  constructor(props) {
    super(props);

    this.state = {
      content: ""
    };
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  componentDidMount(){
    axios.get(Api.url(`/region`))
    .then(response => {
      // console.log(response.data);
    })
    .catch(function (error) {
      console.log(error);
    })
  }

  // validateForm() {
  //   return (this.state.name.length > 0 && this.state.address.length > 0
  //     && this.state.city.length > 0 && this.state.zipcode.length > 0
  //     && this.state.phone.length > 0 && this.state.lattitude.length > 0 && this.state.longitude.length > 0
  //   );
  // }

  handleChange = event => {
    this.setState({
      [event.target.id]: event.target.value
    });
  }

  handleSubmit = event => {
    event.preventDefault();

    const advices = {
      content: this.state.content
    };

    const token = localStorage.getItem('token'); 
    const headers = {
      'Authorization': 'bearer ' + token,
    }

    axios.post(Api.url(`/advice-card`), advices, {headers: headers})
    .then(res => {
      console.log(res.data);
    })
    .catch(error => {
      console.error(error)
    });
  }

  render() {
    return (
      <div className="content">
        <Grid fluid>
          <Row>
            <Col md={12}>
              <Card
                title="Create new advice cards"
                category="Please fill in the required fields *"
                content={
                  <form onSubmit={this.handleSubmit}>  
                    <Row>
                      <Col md={12}>
                        <FormGroup>
                          <ControlLabel>Content *</ControlLabel>
                          <FormControl
                            rows="5"
                            type="file"
                            bsClass="form-control"
                            placeholder="Here can be your text"
                            onChange={this.handleChange}
                            id="content"
                            />
                        </FormGroup>
                      </Col>
                    </Row>
                    <Button bsStyle="info" pullRight fill type="submit">
                      Create advice cards
                    </Button>
                    <div className="clearfix" />
                  </form>
                }
                />
            </Col>
          </Row>
        </Grid>
        {/* <Grid fluid>
          <Row>
            <Col md={12}>
              <Card
                title="Show advice cards"
                category="Please fill in the required fields *"
                content={
                  <form onSubmit={this.handleSubmit}>  
                    <Row>
                      <Col md={12}>
                        <FormGroup>
                          <ControlLabel>Text *</ControlLabel>
                          <FormControl
                            rows="5"
                            componentClass="textarea"
                            bsClass="form-control"
                            placeholder="Here can be your text"
                            onChange={this.handleChange}
                            id="text"
                            />
                        </FormGroup>
                      </Col>
                    </Row>
                    <Button bsStyle="info" pullRight fill type="submit">
                      Create advice cards
                    </Button>
                    <div className="clearfix" />
                  </form>
                }
                />
            </Col>
          </Row>
        </Grid> */}
      </div>
    );
  }
}

export default IndexAdviceCards;
