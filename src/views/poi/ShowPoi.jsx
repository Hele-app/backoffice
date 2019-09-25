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

import Api from '../../config/Api';

class ShowPoi extends Component {

  constructor(props) {
    super(props);
    this.state = {
      pois: [],
    };

    this.handleChange = this.handleChange.bind(this);
  }

  async componentDidMount(){
    const token = await localStorage.getItem('token');
    const headers = {
      'Authorization': 'bearer ' + token,
    };

    axios.get(Api.url(`/poi`), {headers: headers})
      .then((response) => {
        this.setState({
          pois: response.data
        });
      })
      .catch(function (error) {
        console.error(error);
      });
  }

  handleChange = event => {
    this.setState({
      [event.target.id]: event.target.value
    });
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
                                <td>Name</td>
                                  <td>Address</td>
                                    <td>Zip code</td>
                                      <td>City</td>
                                        <td>Region</td>
                                          <td>Phone</td>
                                            <td>Site</td>
                                              <td colSpan="2">Action poi</td>
                              </tr>
                          </thead>
                          <tbody>
                              {this.state.pois.map((poi) => {
                                return (
                                  <tr key={poi.id}>
                                    <td>{poi.name}</td>
                                    <td>{poi.address}</td>
                                    <td>{poi.zipcode}</td>
                                    <td>{poi.city}</td>
                                    <td>{poi.region.name}</td>
                                    <td>{poi.phone}</td>
                                    <td>{poi.site}</td>
                                    <td>
                                      <Link className="btn btn-warning" to={`/admin/poi/edit/${poi.id}`}>
                                        <i className="pe-7s-pen"></i>
                                      </Link>
                                    </td>
                                    <td>
                                      <Link className="btn btn-danger" to={`/admin/poi/delete/${poi.id}`}>
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

export default ShowPoi;
