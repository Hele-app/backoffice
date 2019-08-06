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


class EditPoi extends Component {

  constructor(props) {
    super(props);

    this.state = {
      id: this.props.match.params.id,
      POIS:[],
      name: "",
      adress: "",
      code_postal: "",
      phone: "",
      latitude: "",
      longitude: "",
      description: "",
      site : "",
      horaire : ""
    };

    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
}

handleChange = event => {
  // console.log(event.target.id)
    this.setState({
        // [event.target.id]: event.target.value
        POIS: event.target.value
    });
}


handleSubmit = event => {
    event.preventDefault();

    const poi = {
        name: this.state.name,
        adress: this.state.adress,
        code_postal: this.state.code_postal,
        phone: this.state.phone,
        latitude: this.state.latitude,
        longitude: this.state.longitude,
        description: this.state.description,
        site : this.state.site,
        horaire : this.state.horaire,
    };
    console.log(poi);

    axios.post(`http://127.0.0.1:3333/poi/update/${this.state.id}`, poi)
        .then(res => {
            console.log(res.data);             
        })
        .catch(error => {
            console.log(error)
        });
}

componentDidMount(){
  // console.log("here", this.state.id);
  axios.get(`http://127.0.0.1:3333/poi/edit/${this.state.id}`)
  .then(response => {
    this.setState({ 
      POIS: response.data 
  });
    console.log("data", response.data);
    console.log("name", response.data.name);
    })
    .catch(function (error) {
      console.log(error);
    })
}
deleteUser(event) {
  event.preventDefault();

  axios.delete(`http://127.0.0.1:3333/poi/delete/${this.state.id}`)
  .then(res => {
    console.log(res.data);
    this.setState({deleteMsg: "User is successfully deleted from database"})
  })
  .catch((err) => {
    console.log(err);
  })
}




  render() {
    return (
      <div className="content">
        <Grid fluid>
        <Row>
            <Col md={8}>
              <Card
                title="Edit POI"
                content={
                  <form onSubmit={this.handleSubmit}>
                      <FormInputs
                      ncols={["col-md-12"]}
                      properties={[
                        {  
                          label: "Name",
                          type: "text",
                          bsClass: "form-control",
                          placeholder: "Name",
                          value:this.state.POIS.name,
                          // value:"{response.data.name}",
                          onChange:this.handleChange,
                          id:"name"
                        }
                      ]}
                    />
                    <FormInputs
                      ncols={["col-md-12"]}
                      properties={[
                        {
                          label: "Phone",
                          type: "text",
                          bsClass: "form-control",
                          placeholder: "Phone",
                          onChange:this.handleChange,
                          id:"phone",
                          value:this.state.POIS.phone,
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
                            value:this.state.POIS.site,  
                          }
                        ]}
                    />
                    <FormInputs
                      ncols={["col-md-12"]}
                      properties={[
                        {  
                          label: "Horaire",
                          type: "text",
                          bsClass: "form-control",
                          placeholder: "Horaire",
                          onChange:this.handleChange,
                          id:"horaire",
                          value:this.state.POIS.horaire,  
                        }
                      ]}
                    />
                    <FormInputs
                      ncols={["col-md-12"]}
                      properties={[
                        {
                          label: "Adress",
                          type: "text",
                          bsClass: "form-control",
                          placeholder: "Adress",
                          onChange:this.handleChange,
                          id:"adress",
                          value:this.state.POIS.adress,    
                        }
                      ]}
                      />
                        <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                        {
                          label: "Postal Code",
                          type: "text",
                          bsClass: "form-control",
                          placeholder: "ZIP Code",
                          onChange:this.handleChange,
                          id:"code_postal",
                          value:this.state.POIS.code_postal,     
                        }
                      ]}
                    />
                     <FormInputs
                      ncols={["col-md-12"]}
                      properties={[
                        {
                          label: "Latitude",
                          type: "text",
                          bsClass: "form-control",
                          placeholder: "Latitude",
                          onChange:this.handleChange,
                          id:"latitude",
                          value:this.state.POIS.latitude,  
                        }
                      ]}
                      />
                        <FormInputs
                        ncols={["col-md-12"]}
                        properties={[
                        {
                          label: "Longitude",
                          type: "text",
                          bsClass: "form-control",
                          placeholder: "Longitude",
                          onChange:this.handleChange,
                          id:"longitude",
                          value:this.state.POIS.longitude,  
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
                            value={this.state.POIS.description}
                          />
                        </FormGroup>
                      </Col>
                    </Row>
                    <Button bsStyle="info"  pullRight fill type="submit">
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

export default EditPoi;