import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TransactionsAdminPageRoutingModule } from './transactions-admin-routing.module';

import { TransactionsAdminPage } from './transactions-admin.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TransactionsAdminPageRoutingModule
  ],
  declarations: [TransactionsAdminPage]
})
export class TransactionsAdminPageModule {}
