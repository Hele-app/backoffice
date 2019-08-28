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
  FormControl,
  Table
} from "react-bootstrap";
import { Link} from "react-router-dom";
import { Card } from "components/Card/Card.jsx";
import Button from "components/CustomButton/CustomButton.jsx";
import axios from 'axios';

import Api from '../../config/Api';

class IndexAdviceCards extends Component {

  constructor(props) {
    super(props);

    this.state = {
      content: "",
      contents: []
    };
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  componentDidMount(){
    const token = localStorage.getItem('token'); 
    const headers = {
      'Authorization': 'bearer ' + token,
    }
    
    axios.get(Api.url(`/advice-card`), {headers: headers})
    .then(response => {
      // console.log(response.data);
      this.setState({
        contents: response.data
      });
    })
    .catch(function (error) {
      // console.log(error);
    })
  }

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
                content={
                  <form onSubmit={this.handleSubmit}>  
                    <Row>
                      <Col md={12}>
                        <FormGroup>
                          <ControlLabel>Upload your file</ControlLabel>
                          <FormControl
                            type="file"
                            bsClass="form-control"
                            onChange={this.handleChange}
                            id="content"
                          />
                        </FormGroup>
                      </Col>
                    </Row>
                    <Button bsStyle="info" pullRight fill type="submit">
                      Upload
                    </Button>
                    <div className="clearfix" />
                  </form>
                }
              />
            </Col>
          </Row>
        </Grid>
        <Grid fluid>
          <Row>
            <Col md={12}>
              <Card
                title="All advice cards"
                ctTableFullWidth
                ctTableResponsive
                content={
                  <Table striped hover>
                    <thead>
                      <tr>
                        <td>Content</td>
                        <td colSpan="2">Action advice cards</td>
                      </tr>
                    </thead>
                    <tbody>
                      {this.state.contents.map((cont) => {
                        return (
                          <tr key={cont.id}>
                            <td>{cont.content}</td>                                <td>
                              <Link className="btn btn-danger" to={`/admin/advicecards/delete/${cont.id}`}>
                                <i className="pe-7s-trash"></i>
                              </Link>
                            </td> 
                          </tr>
                        )
                      })}
                    </tbody>
                  </Table>
                }
              />
            </Col>
          </Row>
        </Grid>
      </div>
    );
  }
}

export default IndexAdviceCards;
