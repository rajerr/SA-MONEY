import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TransactionsAdminPage } from './transactions-admin.page';

const routes: Routes = [
  {
    path: '',
    component: TransactionsAdminPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TransactionsAdminPageRoutingModule {}
