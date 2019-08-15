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
import { Card } from "components/Card/Card.jsx";
import { FormInputs } from "components/FormInputs/FormInputs.jsx";
import Button from "components/CustomButton/CustomButton.jsx";
import axios from 'axios';
import { Link } from 'react-router-dom';
import { Redirect } from 'react-router'

import Api from '../../config/Api';

class EditPoi extends Component {

  constructor(props) {
    super(props);

    this.state = {
      id: this.props.match.params.id,
      poiss: {
        name: '',
        phone: '',
        site: '',
        hour: '',
        address: '',
        zipcode: '',
        city: '',
        region_id: '',
        lattitude: '',
        longitude: '',
        description: ''
      },
      isModify: false,
      regions: [],
      region_id:""
    };

    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleChange = event => {
    let poiss = this.state.poiss;
    poiss[event.target.id] = event.target.value;
    this.setState({
      poiss: poiss
    });
    // console.log(this.state.poiss)
  }

  handleSubmit = event => {
    event.preventDefault();

    axios.put(Api.url(`/poi/update/${this.state.id}`), this.state.poiss)
    .then(res => {
      this.setState({ isModify: true });
    })
    .catch(error => {
      console.error(error)
    });
  }

  componentDidMount(){
    Promise.all([
      axios.get(Api.url(`/poi/edit/${this.state.id}`)),
      axios.get(Api.url(`/region`))
    ])
    .then(([response, resregion]) => {
      this.setState({
        poiss: response.data,
        regions: resregion.data
      });
    })
    .catch(function (error) {
      console.error(error);
    })
  }

  render() {
    if (this.state.isModify) {
      return <Redirect to={{ pathname: "/admin/poi" }} />;
    } else {
      return (
        <div className="content">
          <Grid fluid>
            <Row>
              <Col md={8}>
                <Link to={"/admin/poi"} className="btn btn-primary">Back</Link>
                <br />
              </Col>
            </Row>
            <br />
            <Row>
              <Col md={12}>
                <Card
                  title="Edit POI"
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
                            value: this.state.poiss.name,
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
                            value: this.state.poiss.phone,
                            onChange: this.handleChange,
                            id: "phone",
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
                            value: this.state.poiss.site,
                            onChange: this.handleChange,
                            id: "site",
                          }
                        ]}
                        />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "Hour",
                            type: "text",
                            placeholder: "Horaire",
                            value: this.state.poiss.hour,
                            onChange: this.handleChange,
                            id: "hour",
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
                            value: this.state.poiss.address,
                            onChange: this.handleChange,
                            id: "address",
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
                            value: this.state.poiss.zipcode,
                            onChange: this.handleChange,
                            id: "zipcode",
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
                            value: this.state.poiss.city,
                            onChange: this.handleChange,
                            id: "city",
                          }
                        ]}
                        />
                      <Row>
                        <Col md={12}>
                          <FormGroup>
                            <ControlLabel>Region *</ControlLabel>
                            <FormControl componentClass="select" id="region_id" value={this.state.poiss.region_id} onChange={this.handleChange}>
                              {this.state.regions.map((region) => <option key={region.id} value={region.id}>{region.name}</option>)}
                            </FormControl>
                          </FormGroup>
                        </Col>
                      </Row>
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "Lattitude *",
                            type: "text",
                            placeholder: "Lattitude",
                            value: this.state.poiss.lattitude,
                            onChange: this.handleChange,
                            id: "lattitude",
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
                            value: this.state.poiss.longitude,
                            onChange: this.handleChange,
                            id: "longitude",
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
                              value={this.state.poiss.description || ''}
                              onChange={this.handleChange}
                              id="description"
                              />
                          </FormGroup>
                        </Col>
                      </Row>
                      <Button bsStyle="info" pullRight fill type="submit">
                        Update POI
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

export default EditPoi;
