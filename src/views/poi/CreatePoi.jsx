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

class CreatePoi extends Component {

  constructor(props) {
    super(props);

    this.state = {
      name: "",
      phone:"",
      site:"",
      hour:"",
      address:"",
      zipcode:"",
      city:"",
      latitude:"",
      longitude:"",
      description: "",
      isCreate: false,
      regions:[],
      region_id: ""
    };

    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleInputChange = this.handleInputChange.bind(this);
  }

  async componentDidMount() {
    const token = await localStorage.getItem('token');
    const headers = {
      'Authorization': 'bearer ' + token,
    };

    axios.get(Api.url(`/region`), {headers: headers})
    .then(response => {
      // console.log(response.data);
      this.setState({
        regions: response.data
      });
      console.log(this.state.regions)
    })
    .catch(function (error) {
      console.log(error);
    })
  }

  handleInputChange(event) {
    this.setState({
      region_id: event.target.value
    });
  }

  validateForm() {
    return (this.state.name.length > 0 && this.state.address.length > 0
      && this.state.city.length > 0 && this.state.zipcode.length > 0
      && this.state.phone.length > 0 && this.state.latitude.length > 0 && this.state.longitude.length > 0
    );
  }

  handleChange = event => {
    this.setState({
      [event.target.id]: event.target.value
    });
  }

  handleSubmit = event => {
    event.preventDefault();

    const poi = {
      name: this.state.name,
      phone: this.state.phone,
      site: this.state.site,
      hour: this.state.hour,
      address: this.state.address,
      zipcode: this.state.zipcode,
      city: this.state.city,
      latitude: this.state.latitude,
      longitude: this.state.longitude,
      description: this.state.description,
      region_id: this.state.region_id
    };
    // console.log(poi);

    axios.post(Api.url(`/poi/create`), poi)
    .then(res => {
      this.setState({ isCreate: true });
    })
    .catch(error => {
      console.error(error)
    });
  }

  render() {
    if (this.state.isCreate) {
      return <Redirect to={{ pathname: "/admin/Poi" }} />
    } else {
      return (
        <div className="content">
          <Grid fluid>
            <Row>
              <Col md={12}>
                <Link to={"/admin/poi"} className="btn btn-primary">Back</Link>
              </Col>
            </Row>
            <br />
            <Row>
              <Col md={12}>
                <Card
                  title="Create POI"
                  category="Please fill in the required fields *"
                  content={
                    <form onSubmit={this.handleSubmit}>
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "Name *",
                            type: "text",
                            placeholder: "Name",
                            onChange: this.handleChange,
                            id: "name"
                          }
                        ]}
                        />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "Phone *",
                            type: "text",
                            placeholder: "Phone",
                            onChange: this.handleChange,
                            id: "phone"
                          },
                        ]}
                        />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "Site",
                            type: "text",
                            placeholder: "Site",
                            onChange: this.handleChange,
                            id: "site"
                          }
                        ]}
                        />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "Hour",
                            type: "text",
                            placeholder: "Hour",
                            onChange: this.handleChange,
                            id: "hour"
                          }
                        ]}
                        />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "Address *",
                            type: "text",
                            placeholder: "Address",
                            onChange: this.handleChange,
                            id: "address"
                          }
                        ]}
                        />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "ZIP Code *",
                            type: "text",
                            placeholder: "ZIP Code",
                            onChange: this.handleChange,
                            id: "zipcode"
                          }
                        ]}
                        />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "City *",
                            type: "text",
                            placeholder: "City",
                            onChange: this.handleChange,
                            id: "city"
                          }
                        ]}
                        />
                      <Row>
                        <Col md={12}>
                          <FormGroup>
                            <ControlLabel>Region *</ControlLabel>
                            <FormControl componentClass="select" id="region_id" onChange={this.handleChange}>
                              {this.state.regions.map((region) => <option key={region.id} value={region.id}>{region.name}</option>)}
                            </FormControl>
                          </FormGroup>
                        </Col>
                      </Row>
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "latitude *",
                            type: "text",
                            placeholder: "latitude",
                            onChange: this.handleChange,
                            id: "latitude"
                          }
                        ]}
                        />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "Longitude *",
                            type: "text",
                            placeholder: "Longitude",
                            onChange: this.handleChange,
                            id: "longitude"
                          }
                        ]}
                        />
                      <Row>
                        <Col md={12}>
                          <FormGroup>
                            <ControlLabel>Description</ControlLabel>
                            <FormControl
                              rows="5"
                              componentClass="textarea"
                              bsClass="form-control"
                              placeholder="Here can be your description"
                              onChange={this.handleChange}
                              id="description"
                              />
                          </FormGroup>
                        </Col>
                      </Row>
                      <Button bsStyle="info" pullRight fill type="submit">
                        Create POI
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
  }
}

export default CreatePoi;
