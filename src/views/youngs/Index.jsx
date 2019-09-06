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
import { Grid, Row, Col, Table } from "react-bootstrap";

import Card from "components/Card/Card.jsx";
import CustomCheckbox from 'components/CustomCheckbox/CustomCheckbox.jsx';
import axios from 'axios';

import Api from '../../config/Api';

class IndexYoungs extends Component {

  constructor(props) {
    super(props);
    this.state = {
      youngs: []
    };
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  async componentDidMount(){
    const token = await localStorage.getItem('token');
    const headers = {
      'Authorization': 'bearer ' + token,
    };
    axios.get(Api.url(`/admin/users`), {headers: headers})
      .then(response => {
        console.log(response.data);
        this.setState({
          youngs: response.data.users
        });
      })
      .catch(function (error) {
      });
  }

  handleChange = event => {
    this.setState({
      [event.target.id]: event.target.value
    });
  }

  handleSubmit = async event => {
    event.preventDefault();

    const token = await localStorage.getItem('token');
    const headers = {
      'Authorization': 'bearer ' + token,
    };

    axios.post(Api.url(`/admin/users`), {}, {headers: headers})
      .then(res => {
      })
      .catch(error => {
	      console.error(error);
      });
  }

  render() {
    return (
      <div className="content">
        <Grid fluid>
          <Row>
            <Col md={12}>
              <Card
                title="Les jeunes"
                category="Tous les jeunes"
                ctTableFullWidth
                ctTableResponsive
                content={
                    <Table striped hover>
                        <thead>
                            <tr>
                                <th>ID</th>
                                  <th>Téléphone</th>
                                    <th>Pseudonyme</th>
                                      <th>Actif</th>
                              </tr>
                          </thead>
                          <tbody>
                              {this.state.youngs.map((young) => {
                                if (young.roles === "YOUNG") {
                                  return (
                                    <tr key={young.id}>
                                      <td key='id'>{young.id}</td>
                                      <td key='phone'>{young.phone}</td>
                                      <td key='username'>{young.username}</td>
                                      <td key='active'><CustomCheckbox isChecked={true}/></td>
                                    </tr>
                                  );
                                }
                                else {
                                  return null;
                                }
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

export default IndexYoungs;
