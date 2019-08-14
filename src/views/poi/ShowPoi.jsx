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
  Table
} from "react-bootstrap";


import { Card } from "components/Card/Card.jsx";
import { Link} from "react-router-dom";

import axios from 'axios';

class ShowPoi extends Component {

  constructor(props) {
    super(props);
    this.state = {
      poi: [],
      regions:[],
      region_id:"",
      name: "",
      phone:"",
      site:"",
      hour:"",
      address:"",
      zipcode:"",
      city:"",
      lattitude:"",
      longitude:"",
      description: ""
    };

    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }
  
  componentDidMount(){
      axios.get('http://127.0.0.1:3333/poi')
    .then((response) => {
      console.log(response.data);
      this.setState({ 
        poi: response.data
      });     
      console.log(this.state.regions) 
      console.log(this.state.regions[0].name);
    })
    .catch(function (error) {
      console.log(error);
    })
  }  
  
  handleChange = event => {
  // console.log(event.target.id)
    this.setState({
        [event.target.id]: event.target.value
    });
}


handleSubmit = event => {
    event.preventDefault();

    axios.get(`http://127.0.0.1:3333/poi/delete/${this.state.id}`)
    .then(res => {
      console.log(res.data);
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
          <Col md={12}>
              <Card
                title="All poi"
                ctTableFullWidth
                ctTableResponsive
                content={
                  <Table striped hover>
                    <thead>
                      <tr>
                        <td>id</td>
                        <td>Name</td>
                        <td>Phone</td>
                        <td>Site</td>
                        <td>Hour</td>
                        <td>Address</td>
                        <td>Zip code</td>
                        <td>City</td>
                        <td>Lattitude</td>
                        <td>Longitude</td>
                        <td>Description</td>
                        <td>Region</td>
                        <td colspan="3">Action poi</td>
                      </tr>
                    </thead>
                    <tbody>
                      {this.state.poi.map((pois) => {
                        console.log(pois)
                        return (
                          <tr>
                              <td>{pois.id}</td>
                              <td>{pois.name}</td>
                              <td>{pois.phone}</td>
                              <td>{pois.site}</td>
                              <td>{pois.hour}</td>
                              <td>{pois.address}</td>
                              <td>{pois.zipcode}</td>
                              <td>{pois.city}</td>
                              <td>{pois.lattitude}</td>
                              <td>{pois.longitude}</td>
                              <td>{pois.description}</td>
                              <td>{pois.region.name}</td>
                              <td>
                                <Link to={"/Admin/EditPoi/"+pois.id} className="btn btn-primary">Edit</Link>
                              </td>
                              <td>
                                <td><Link className="btn btn-danger" to={"/Admin/DeletePoi/"+pois.id}>Delete</Link></td>
                              </td>
                              <p style={{color: 'green'}}>{this.state.addMsg}</p>
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

export default ShowPoi;