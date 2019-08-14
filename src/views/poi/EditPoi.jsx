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

class EditPoi extends Component {

  constructor(props) {
    super(props);

    this.state = {
      id: this.props.match.params.id,
      poiss: {},
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

    axios.post(`http://127.0.0.1:3333/poi/update/${this.state.id}`, this.state.poiss)
    .then(res => {
      // console.log(res.data);  
      this.setState({ isCreate: true }); 
      alert("successfully update !");              
    })
    .catch(error => {
      // console.log(error)
    });
  }
  // validateForm() {
  //   return (this.state.name.length > 0 && this.state.address.length > 0 
  //     && this.state.city.length > 0 && this.state.zipcode.length > 0
  //     && this.state.phone.length > 0 && this.state.lattitude.length > 
  //     0 && this.state.longitude.length > 0
  //   );
  // }

  componentDidMount(){
    Promise.all([
      axios.get(`http://127.0.0.1:3333/poi/edit/${this.state.id}`),
      axios.get(`http://127.0.0.1:3333/poi/region`)
    ])
    .then(([response, resregion]) => {
      // console.log(response.data);
      // console.log(resregion.data);
      this.setState({ 
        poiss: response.data,
        regions: resregion.data
    });
    // console.log(this.state.poiss)
    // console.log(this.state.regions)
    })
    .catch(function (error) {
      // console.log(error);
    })
  }
  
  render() {
  if (this.state.isModify) {
    return <Redirect to={{ pathname: "/admin/Poi" }} />;
  } else {
    return (
      <div className="content">
        <Grid fluid>
        <Row>
            <Col md={8}>
              <Card
                title="Edit POI"
                category="Please fill in the required fields *"
                content={
                  <form onSubmit={this.handleSubmit}>
                      <label>
                        Region :
                        <select id="region_id" value={this.state.poiss.region_id} onChange={this.handleChange}>{this.state.regions.map((region) => <option key={region.id} value={region.id}>{region.name}</option>)}</select> *
                      </label>
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {  
                            label: "Name *",
                            type: "text",
                            bsClass: "form-control",
                            placeholder: "Name",
                            value:this.state.poiss.name,
                            onChange:this.handleChange,
                            id:"name"
                          }
                        ]}
                      />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "Phone *",
                            type: "text",
                            bsClass: "form-control",
                            placeholder: "Phone",
                            onChange:this.handleChange,
                            id:"phone",
                            value:this.state.poiss.phone,
                          },
                        ]}
                      />
                      <FormInputs
                        ncols={["col-md-12"]}
                          properties={[
                            {
                              label: "Site",
                              type: "text",
                              bsClass: "form-control",
                              placeholder: "Site",
                              controlId:"site",
                              onChange:this.handleChange,
                              id:"site",
                              value:this.state.poiss.site,  
                            }
                          ]}
                      />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {  
                            label: "Hour",
                            type: "text",
                            bsClass: "form-control",
                            placeholder: "Horaire",
                            onChange:this.handleChange,
                            id:"hour",
                            value:this.state.poiss.hour,  
                          }
                        ]}
                      />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "Address *",
                            type: "text",
                            bsClass: "form-control",
                            placeholder: "Address",
                            onChange:this.handleChange,
                            id:"address",
                            value:this.state.poiss.address,    
                          }
                        ]}
                      />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "ZIP Code *",
                            type: "text",
                            bsClass: "form-control",
                            placeholder: "ZIP Code",
                            onChange:this.handleChange,
                            id:"zipcode",
                            value:this.state.poiss.zipcode,     
                          }
                        ]}
                      />
                      <FormInputs
                      ncols={["col-md-12"]}
                      properties={[
                        {
                          label: "City *",
                          type: "text",
                          bsClass: "form-control",
                          placeholder: "City",
                          onChange:this.handleChange,
                          id:"city",
                          value:this.state.poiss.city,      
                        }
                      ]}
                    />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "Lattitude *",
                            type: "text",
                            bsClass: "form-control",
                            placeholder: "Lattitude",
                            onChange:this.handleChange,
                            id:"lattitude",
                            value:this.state.poiss.lattitude,  
                          }
                        ]}
                      />
                      <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                          {
                            label: "Longitude *",
                            type: "text",
                            bsClass: "form-control",
                            placeholder: "Longitude",
                            onChange:this.handleChange,
                            id:"longitude",
                            value:this.state.poiss.longitude,  
                          }
                        ]}
                      />
                      <Row>
                        <Col md={12}>
                          <FormGroup controlId="description">
                            <ControlLabel>Description</ControlLabel>
                            <FormControl
                              rows="5"
                              componentClass="textarea"
                              bsClass="form-control"
                              placeholder="Here can be your description"
                              onChange={this.handleChange}
                              value={this.state.poiss.description}
                            />
                          </FormGroup>
                        </Col>
                      </Row>
                      <Button bsStyle="info" /*disabled={!this.validateForm()} */pullRight fill type="submit">
                        Update POI
                      </Button>
                      <div className="clearfix" />
                  </form>
                }
              />
            </Col>
          </Row>
          <Row>
            <Col md={8}>
            <Link to={"/Admin/Poi"} className="btn btn-primary">Back</Link>
            <br />
            </Col>
          </Row>
        </Grid>   
      </div>
    );
    }
  }
}

export default EditPoi;