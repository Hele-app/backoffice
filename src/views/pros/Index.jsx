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
  Alert,
  Grid,
  Row,
  Col,
  Table } from "react-bootstrap";
import Button from 'components/CustomButton/CustomButton';
import { Card } from "components/Card/Card.jsx";
import axios from 'axios';

import Api from '../../config/Api';
import ProForm from './ProForm.jsx';

class IndexPros extends Component {

  constructor(props) {
    super(props);
    this.state = {
      pros: [],
      userToUpdate: null,
      showForm: false,
      showNotification: false
    };
    this.closeForm = this.closeForm.bind(this)
    this.updatePros = this.updatePros.bind(this)
    this.handleDelete = this.handleDelete.bind(this)
  }

  async componentDidMount(){
    const token = await localStorage.getItem('token');
    const headers = {
      'Authorization': 'bearer ' + token,
    };
    const params = {
      roles: "PROFESSIONAL|MODERATOR|ADMIN",
    };
    axios.get(Api.url(`/admin/users`), {headers: headers, params: params})
         .then(response => {
           this.setState({
             pros: response.data.users
           });
         })
         .catch(function (error) {
         });
  }
  closeForm(success) {
    this.setState({
      showForm: false,
      showNotification: success,
      userToUpdate: null
    })
  }

  async handleDelete(id) {
    console.log(id);
    const token = await localStorage.getItem('token');
    const headers = {
      'Authorization': 'bearer ' + token,
    };
    axios.delete(Api.url(`/admin/users/${id}`), {headers: headers})
         .then(response => {
           this.updatePros();
         })
         .catch(function (error) {
           console.log(error);
         });
  }

  async updatePros() {
    const token = await localStorage.getItem('token');
    const headers = {
      'Authorization': 'bearer ' + token,
    };
    const params = {
      roles: "PROFESSIONAL|MODERATOR|ADMIN",
    };
    axios.get(Api.url(`/admin/users`), {headers: headers, params: params})
         .then(response => {
           this.setState({
             pros: response.data.users
           });
         })
         .catch(function (error) {
         });
  }

  render() {
    return (
      <div className="content">
          {this.state.showNotification ?
           <div className="card">
             <Alert bsStyle="success">
               <button type="button" aria-hidden="true" className="close" onClick={e => this.setState({showNotification: false})}>×</button>
               <span><b>Professionnel ajouté !</b></span>
             </Alert>
           </div> : null}
        <Grid fluid>
          <Row style={{marginBottom: "10px"}}>
            <Col md={12}>
              <i className="pe-7s-add-user btn btn-primary" style={{fontSize: "3em"}} onClick={e => this.setState({showForm: !this.state.showForm})} />
            </Col>
          </Row>
          <Row>
            <Col md={12}>
              {this.state.showForm ? <ProForm closeForm={this.closeForm} addPro={this.updatePros}
              user={this.state.userToUpdate}/> :
              <Card
                title="Les professionnels"
                ctTableFullWidth
                ctTableResponsive
                content={
                  <Table striped hover>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Téléphone</th>
                        <th>E-Mail</th>
                        <th>Profession</th>
                        <th>Role</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      {this.state.pros.map((pro) => {
                         return (
                           <tr key={pro.id}>
                             <td key='id'>{pro.id}</td>
                             <td key='phone'>{pro.phone}</td>
                             <td key='email'>{pro.email}</td>
                             <td key='profession'>{pro.profession}</td>
                             <td key='roles'>{pro.roles}</td>
                             <td>
                               <Button bsStyle="primary" style={Object.assign({}, ACTION_BUTTONS, {marginRight: "5px"})} onClick={e => this.setState({showForm: true, userToUpdate: pro})}>
                                 <i className="pe-7s-note" style={ACTION_FONTS}/>
                               </Button>
                               <Button bsStyle="danger" style={ACTION_BUTTONS} onClick={e => this.handleDelete(pro.id)} >
                                 <i className="pe-7s-delete-user" style={ACTION_FONTS} />
                               </Button>
                             </td>
                           </tr>
                         );
                      })}
                    </tbody>
                  </Table>
                }
                  />}
            </Col>
          </Row>
        </Grid>
      </div>
    );
  }
}

export default IndexPros;

const ACTION_FONTS = {
  fontSize: "30px"
}

const ACTION_BUTTONS = {
  padding: "0px 20px"
}
