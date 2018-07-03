import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import *  as AppConfig from '../app/config';

import {Http} from '@angular/http';
@IonicPage()
@Component({
  selector: 'page-stores-view',
  templateUrl: 'stores-view.html',
})
export class StoresViewPage {
  private cfg: any;

  allBars:any[]=[]
  constructor(public navCtrl: NavController, public navParams: NavParams,private http: Http,) {
    this.cfg = AppConfig.cfg;
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad StoresViewPage');
  }


  getAllBars(){
   /*  this.headers = new Headers();
    this.headers.append("Content-Type", 'application/json');
    this.headers.append("Access-Control-Allow-Origin", "*");
    this.headers.append("Access-Control-Allow-Headers", "Origin, Authorization, Content-Type, Accept"); 
  let options = new RequestOptions({ headers: this.headers }); // Create a request option
  //console.log("URL IS  boka chele-->",this.url) */

  return this.http.get(this.cfg.apiUrl+'/viewAllBars').subscribe(res => {
  
  //  let data = JSON.parse(res['barDetails']);
    console.log(res.json().barDetails)
   this.allBars= res.json().barDetails
  // console.log("All Bars",this.allBars.length)
  }, error => {
    console.error(error);
  });


  }

}
