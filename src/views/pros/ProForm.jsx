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
import Button from 'components/CustomButton/CustomButton';
import { Card } from "components/Card/Card.jsx";
import { FormInputs } from "components/FormInputs/FormInputs.jsx";
import axios from 'axios';

import Api from '../../config/Api';

const START_YEAR = 1930;
const NB_YEARS = 70;
const DEFAULT_USER = {
  phone: "",
  username: "",
  email: "",
  profession: "",
  city: "",
  phone_pro: "",
  birthyear: START_YEAR + NB_YEARS - 1,
  region_id: 1,
  roles: "MODERATOR"
}

class ProForms extends Component {

  constructor(props) {
    super(props);
    let user = null;
    if (props.user !== undefined && props.user !== null) {
      user = props.user;
    }
    else {
      user = DEFAULT_USER;
    }
    this.state = {
      regions: [],
      user: user,
      token: null
    };
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  async componentDidMount(){
    const token = await localStorage.getItem('token');
    const headers = {
      'Authorization': 'bearer ' + token,
    };
    axios.get(Api.url(`/region`), {headers: headers})
         .then(response => {
           this.setState({
             regions: response.data,
             token: token
           });
         })
         .catch(function (error) {
         });
  }

  handleChange(event) {
    this.setState({
      user: Object.assign({}, this.state.user, {[event.target.id]: event.target.value})
    })
  }

  handleSubmit(event) {
    event.preventDefault();
    const headers = {
      'Authorization': 'bearer ' + this.state.token,
    };
    let request = null;
    if (this.state.user.hasOwnProperty('id')) {
      request = axios.put(Api.url(`/admin/users/${this.state.user.id}`),
                          this.state.user, {headers: headers});
    }
    else {
      request = axios.post(Api.url(`/admin/users/`), this.state.user,
                           {headers: headers});
    }
    request
      .then(response => {
        this.props.addPro();
        this.props.closeForm(true);
      })
      .catch(error => {
        console.log(error);
      })
  }

  render() {
    const years = Array(NB_YEARS).fill(START_YEAR).map((x, y) => x + y);
    return (
      <Card
        title="Ajouter un professionnel"
        content={
          <form onSubmit={this.handleSubmit}>
            <FormInputs
              ncols={["col-md-6", "col-md-6"]}
              properties={[
                {
                  id: "phone",
                  required: true,
                  label: "Téléphone *",
                  type: "text",
                  bsClass: "form-control",
                  placeholder: "0612345678",
                  value: this.state.user.phone ? this.state.user.phone : "",
                  onChange: this.handleChange
                },
                {
                  id: "username",
                  required: true,
                  label: "Pseudonyme *",
                  type: "text",
                  bsClass: "form-control",
                  placeholder: "Thomas",
                  value: this.state.user.username ? this.state.user.username : "",
                  onChange: this.handleChange
                },
              ]}
            />
            <FormInputs
              ncols={["col-md-6", "col-md-6"]}
              properties={[
                {
                  id: "email",
                  required: true,
                  label: "E-Mail *",
                  type: "email",
                  bsClass: "form-control",
                  placeholder: "thomas@gmail.com",
                  value: this.state.user.email ? this.state.user.email : "",
                  onChange: this.handleChange
                },
                {
                  id: "profession",
                  required: true,
                  label: "Profession *",
                  type: "text",
                  bsClass: "form-control",
                  placeholder: "Psychologue",
                  value: this.state.user.profession ? this.state.user.profession : "",
                  onChange: this.handleChange
                },
              ]}
            />
            <FormInputs
              ncols={["col-md-6", "col-md-6"]}
              properties={[
                {
                  id: "birthyear",
                  required: true,
                  label: "Année de naissance *",
                  bsClass: "form-control",
                  componentClass: "select",
                  options: years,
                  value: this.state.user.birthyear,
                  onChange: this.handleChange
                },
                {
                  id: "region_id",
                  required: true,
                  label: "Région *",
                  type: "text",
                  bsClass: "form-control",
                  componentClass: "select",
                  options: this.state.regions,
                  value: this.state.user.region_id,
                  onChange: this.handleChange
                },
              ]}
            />
            <FormInputs
              ncols={["col-md-6", "col-md-6"]}
              properties={[
                {
                  id: "city",
                  label: "Ville",
                  type: "text",
                  bsClass: "form-control",
                  placeholder: "Paris",
                  value: this.state.user.city ? this.state.user.city : "",
                  onChange: this.handleChange
                },
                {
                  id: "phone_pro",
                  label: "Téléphone Pro",
                  type: "text",
                  bsClass: "form-control",
                  placeholder: "0612345678",
                  value: this.state.user.phone_pro ? this.state.user.phone_pro : "",
                  onChange: this.handleChange
                },
              ]}
            />
            <FormInputs
              ncols={["col-md-6"]}
              properties={[
                {
                  id: "roles",
                  required: true,
                  label: "Role",
                  bsClass: "form-control",
                  componentClass: "select",
                  options: ["MODERATOR", "PROFESSIONAL", "ADMIN"],
                  value: this.state.user.roles,
                  onChange: this.handleChange
                }
              ]}
            />
            <Button bsStyle="success" pullRight fill type="submit">
              Sauvegarder
            </Button>
            <small>* champs requis</small>
            <div className="clearfix" />
          </form>} />
    );
  }
}

export default ProForms;
