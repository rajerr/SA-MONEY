import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: 'home',
    loadChildren: () => import('./home/home.module').then( m => m.HomePageModule)
  },
  {
    path: '',
    redirectTo: 'home',
    pathMatch: 'full'
  },
  {
    path: 'login',
    loadChildren: () => import('./login/login.module').then( m => m.LoginPageModule)
  },
  {
    path: 'admin',
    loadChildren: () => import('./admin/admin.module').then( m => m.AdminPageModule)
  },
  {
    path: 'user',
    loadChildren: () => import('./user/user.module').then( m => m.UserPageModule)
  },
  {
    path: 'menu-admin',
    loadChildren: () => import('./menu-admin/menu-admin.module').then( m => m.MenuAdminPageModule)
  },
  {
    path: 'menu-user',
    loadChildren: () => import('./menu-user/menu-user.module').then( m => m.MenuUserPageModule)
  },
  {
    path: 'transactions',
    loadChildren: () => import('./transactions/transactions.module').then( m => m.TransactionsPageModule)
  },
  {
    path: 'depot',
    loadChildren: () => import('./depot/depot.module').then( m => m.DepotPageModule)
  },
  {
    path: 'retrait',
    loadChildren: () => import('./retrait/retrait.module').then( m => m.RetraitPageModule)
  },
  {
    path: 'header',
    loadChildren: () => import('./header/header.module').then( m => m.HeaderPageModule)
  },
  {
    path: 'show-string',
    loadChildren: () => import('./show-string/show-string.module').then( m => m.ShowStringPageModule)
  },
  {
    path: 'confirm-depot',
    loadChildren: () => import('./confirm-depot/confirm-depot.module').then( m => m.ConfirmDepotPageModule)
  },
  {
    path: 'confirm-retrait',
    loadChildren: () => import('./confirm-retrait/confirm-retrait.module').then( m => m.ConfirmRetraitPageModule)
  },
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
