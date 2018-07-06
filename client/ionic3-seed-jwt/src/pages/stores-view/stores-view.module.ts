import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { StoresViewPage } from './stores-view';

@NgModule({
  declarations: [
    StoresViewPage,
  ],
  imports: [
    IonicPageModule.forChild(StoresViewPage),
  ],
  exports: [
    StoresViewPage
  ]
})
export class StoresViewPageModule {}
