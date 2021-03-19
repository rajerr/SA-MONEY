import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { CalculateurUserPageRoutingModule } from './calculateur-user-routing.module';

import { CalculateurUserPage } from './calculateur-user.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    CalculateurUserPageRoutingModule,
    ReactiveFormsModule
  ],
  declarations: [CalculateurUserPage]
})
export class CalculateurUserPageModule {}
