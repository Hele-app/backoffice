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


import { Redirect} from 'react-router-dom';
import axios from 'axios';


class DeletePoi extends Component {

  constructor(props){
    super(props)
    this.state = {
      isDelete: false,
      id: this.props.match.params.id
    }
    console.log(this.props.match.params.id);
  }
  
  delete() {
    axios.get(`http://127.0.0.1:3333/poi/delete/${this.state.id}`)
    .then(res => {
      this.setState({
        isDelete: true,
        deleteMsg: "User is successfully deleted from database"
      })
    })
    .catch(error => {
      console.log(error);
    })
  }
  
  render() {
    if (this.state.isDelete) {
      return <Redirect to={{ pathname: "/Admin/Poi" }} />;
    } else {
      return(
        <div>
          <h1>Supprimer la poi</h1>
          <p>Voulez-vous supprimer cette poi? </p>
          <div>
            <button onClick={this.delete()}>Oui</button>
            <button href="/Admin/Poi">Non</button>
          </div>
        </div>
      );
    }
  }
}

export default DeletePoi;