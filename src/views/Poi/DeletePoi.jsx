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



import ShowPoi from "./ShowPoi.jsx";
import { Link, Redirect} from 'react-router-dom';
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
                this.setState({isDelete: true})
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


  // render() {
  //   return (
  //     <div className="content">
  //       <Grid fluid>
  //         <Row>
  //           <Col md={12}>
  //             <Link to={"/Admin/CreatePoi"} className="btn btn-primary">Create POI</Link>
  //           </Col>
  //         </Row>
  //       </Grid>
  //       <br />
  //       <ShowPoi />
  //     </div>
  //   );
  // }
}

export default DeletePoi;



// import React from 'react';
// import { Link, Redirect} from 'react-router-dom';
// import axios from 'axios';

// export default class Delete extends React.Component 
// {
//     constructor(props){
//         super(props)
//         this.state = {
//             isDelete: false,
//             id: this.props.match.params.id
//         }
//     }

//     delete() {
//         axios.delete(`http://localhost:8000/api/admin/category/${this.state.id}`)
//         .then(res => {
//             alert(res.data.success); 
//             this.setState({isDelete: true})
//         })
//         .catch(error => {
//             console.log(error);
//         })
//     }

//     render() {
//         if (this.state.isDelete) {
//             return <Redirect to={{ pathname: "/admin/categories" }} />;
//         } else {
//             return(
//                 <div>
//                     <h1>Supprimer la categorie</h1>

//                     <p>Voulez-vous supprimer cette categorie ? </p>

//                     <div>
//                         <button onClick={this.delete()}>Oui</button>
//                         <button href="/admin/categories">Non</button>
//                     </div>

//                 </div>
//             );
//         }
    
//     }
// }