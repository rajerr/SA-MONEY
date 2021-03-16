import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ShowStringPageRoutingModule } from './show-string-routing.module';

import { ShowStringPage } from './show-string.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ShowStringPageRoutingModule
  ],
  declarations: [ShowStringPage]
})
export class ShowStringPageModule {}
