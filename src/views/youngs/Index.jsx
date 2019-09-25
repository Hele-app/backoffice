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
import Checkbox from 'components/CustomCheckbox/CustomCheckbox';
import axios from 'axios';

import Api from '../../config/Api';

class IndexYoungs extends Component {

  constructor(props) {
    super(props);
    this.state = {
      youngs: []
    };
    this.handleChange = this.handleChange.bind(this);
  }

  async componentDidMount(){
    const token = await localStorage.getItem('token');
    const headers = {
      'Authorization': 'bearer ' + token,
    };
    const params = {
      roles: "YOUNG",
    };
    axios.get(Api.url(`/admin/users`), {headers: headers, params: params})
      .then(response => {
        this.setState({
          youngs: response.data.users
        });
      })
      .catch(function (error) {
      });
  }

  async handleChange(event) {
    event.persist();
    const id = parseInt(event.target.id);
    const young = this.state.youngs.find(item => item.id === id);
    const data = { active: !young.active };
    const token = await localStorage.getItem('token');
    const headers = {
      'Authorization': 'bearer ' + token,
    };
    axios.put(Api.url(`/admin/users/${event.target.id}`), data, {headers: headers})
      .then(res => {
        this.setState({youngs: this.state.youngs.map(item => {
          return item.id === id ? res.data.user : item;
        })});
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
                         return (
                           <tr key={young.id}>
                             <td key='id'>{young.id}</td>
                             <td key='phone'>{young.phone}</td>
                             <td key='username'>{young.username}</td>
                             <td key='active'>
                               <Checkbox
                                 number={young.id}
                                 isChecked={young.active ? true : false}
                                 onChange={this.handleChange}
                               />
                             </td>
                           </tr>
                         );
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
