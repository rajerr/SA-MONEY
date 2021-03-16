import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ConfirmDepotPage } from './confirm-depot.page';

const routes: Routes = [
  {
    path: '',
    component: ConfirmDepotPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ConfirmDepotPageRoutingModule {}
