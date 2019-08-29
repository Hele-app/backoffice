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
  Button
} from "react-bootstrap";
import { Card } from "components/Card/Card.jsx";

import { Link, Redirect} from 'react-router-dom';
import axios from 'axios';

import Api from '../../config/Api';

class DeleteAdviceCard extends Component {

  constructor(props){
    super(props)
    this.state = {
      isDelete: false,
      id: this.props.match.params.id
    }

    this.handleDelete = this.handleDelete.bind(this);
  }

  handleDelete() {
    const token = localStorage.getItem('token'); 
    const headers = {
      'Authorization': 'bearer ' + token,
    }
    axios.delete(Api.url(`/advice-card/${this.state.id}`), {headers: headers})
    .then(res => {
      this.setState({
        isDelete: true,
        // deleteMsg: "advice cards is successfully deleted from database"
      })
    })
    .catch(error => {
      console.log(error);
    })
  }

  render() {
    if (this.state.isDelete) {
      return <Redirect to={{ pathname: "/admin/advicecards" }} />;
    } else {
      return(
        <div className="content">
          <Grid fluid>
            <Row>
              <Col md={12}>
                <Card
                  title="Delete the advice cards"
                  ctTableFullWidth
                  ctTableResponsive
                  content={
                    <div>
                      <p>Do you want to delete this advice cards?</p>
                      <div>
                        <Button className="btn btn-danger" onClick={this.handleDelete}>Oui</Button>
                        
                        <Link className="btn btn-default" to={`/admin/advicecards`}>Non</Link>
                      </div>
                    </div>
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

export default DeleteAdviceCard;
