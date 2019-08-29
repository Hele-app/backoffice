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
import { FormInputs } from "components/FormInputs/FormInputs.jsx";
import axios from 'axios';

import Api from '../../config/Api';

class IndexArticle extends Component {

  constructor(props) {
    super(props);
    this.state = {
      title: "",
      path: "",
      articles: []
    };
    this.handleChange = this.handleChange.bind(this);
    this.handleChangeFile = this.handleChangeFile.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  componentDidMount(){
    const token = localStorage.getItem('token');
    const headers = {
      'Authorization': 'bearer ' + token,
    }
    axios.get(Api.url(`/articles`), {headers: headers})
    .then(response => {
      console.log(response.data)
      this.setState({
        articles: response.data
      });
      console.log(this.state.articles)
    })
    .catch(function (error) {
    })
  }

  handleChange = event => {
    this.setState({
      [event.target.id]: event.target.value
    });
  }
  handleChangeFile = event => {
    this.setState({
      [event.target.id]: event.target.files[0]
    });
  }

  handleSubmit = event => {
    event.preventDefault();
    var bodyFormData = new FormData();
    bodyFormData.set('title', this.state.title);
    bodyFormData.append('article_pdf', this.state.path);

    const token = localStorage.getItem('token');
    const headers = {
      'Authorization': 'Bearer ' + token,
      'Content-Type': 'multipart/form-data'
    }

    axios.post(Api.url(`/article/upload`), bodyFormData, {headers})
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
                title="Create new article"
                content={
                  <form onSubmit={this.handleSubmit}>
                    <Row>
                      <Col md={12}>
                        <FormGroup>
                          <ControlLabel>Upload your file</ControlLabel>
                          <FormInputs
                            ncols={["col-md-12"]}
                            properties={[
                              {
                                label: "Title *",
                                type: "text",
                                placeholder: "Title",
                                onChange: this.handleChange,
                                id: "title",
                                name: "title"
                              }
                            ]}
                          />
                          <FormControl
                            type="file"
                            accept="application/pdf"
                            bsClass="form-control"
                            onChange={this.handleChangeFile}
                            id="path"
                            name="path"
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
                title="All articles"
                ctTableFullWidth
                ctTableResponsive
                content={
                  <Table striped hover>
                    <thead>
                      <tr>
                        <td>Id</td>
                        <td>Title</td>
                        <td colSpan="2">Action articles</td>
                      </tr>
                    </thead>
                    <tbody>
                      {this.state.articles.map((articl) => {
                        return (
                          <tr key={articl.id}>
                            <td>{articl.id}</td>
                            <td>{articl.title}</td>
                            <td>
                              <Link className="btn btn-danger" to={`/admin/article/${articl.id}`}>
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

export default IndexArticle;
