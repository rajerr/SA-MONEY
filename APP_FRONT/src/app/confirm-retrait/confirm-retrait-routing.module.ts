import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ConfirmRetraitPage } from './confirm-retrait.page';

const routes: Routes = [
  {
    path: '',
    component: ConfirmRetraitPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ConfirmRetraitPageRoutingModule {}
