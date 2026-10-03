<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Full system access including users, roles, permissions, settings and all CMS modules.',
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Day-to-day CMS and organizational management without system-level access control.',
            ],
            [
                'name' => 'Content Manager',
                'slug' => 'content-manager',
                'description' => 'Creates and manages website content. Publishing is reserved for Admin and Super Admin.',
            ],
            [
                'name' => 'Finance Manager',
                'slug' => 'finance-manager',
                'description' => 'Manages fundraising campaigns and donation/payment records.',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['slug' => $roleData['slug']],
                $roleData
            );
        }

        $permissionDefinitions = [
            [
                'users.view',
                'Users — View',
                'users',
                'view'
            ],
            [
                'users.create',
                'Users — Create',
                'users',
                'create'
            ],
            [
                'users.update',
                'Users — Update',
                'users',
                'update'
            ],
            [
                'users.delete',
                'Users — Delete',
                'users',
                'delete'
            ],
            [
                'roles.view',
                'Roles — View',
                'roles',
                'view'
            ],
            [
                'roles.create',
                'Roles — Create',
                'roles',
                'create'
            ],
            [
                'roles.update',
                'Roles — Update',
                'roles',
                'update'
            ],
            [
                'roles.delete',
                'Roles — Delete',
                'roles',
                'delete'
            ],
            [
                'permissions.view',
                'Permissions — View',
                'permissions',
                'view'
            ],
            [
                'permissions.create',
                'Permissions — Create',
                'permissions',
                'create'
            ],
            [
                'permissions.update',
                'Permissions — Update',
                'permissions',
                'update'
            ],
            [
                'permissions.delete',
                'Permissions — Delete',
                'permissions',
                'delete'
            ],
            [
                'pages.view',
                'Pages — View',
                'pages',
                'view'
            ],
            [
                'pages.create',
                'Pages — Create',
                'pages',
                'create'
            ],
            [
                'pages.update',
                'Pages — Update',
                'pages',
                'update'
            ],
            [
                'pages.delete',
                'Pages — Delete',
                'pages',
                'delete'
            ],
            [
                'pages.publish',
                'Pages — Publish',
                'pages',
                'publish'
            ],
            [
                'page_sections.view',
                'Page Sections — View',
                'page_sections',
                'view'
            ],
            [
                'page_sections.create',
                'Page Sections — Create',
                'page_sections',
                'create'
            ],
            [
                'page_sections.update',
                'Page Sections — Update',
                'page_sections',
                'update'
            ],
            [
                'page_sections.delete',
                'Page Sections — Delete',
                'page_sections',
                'delete'
            ],
            [
                'page_sections.publish',
                'Page Sections — Publish',
                'page_sections',
                'publish'
            ],
            [
                'navigations.view',
                'Navigations — View',
                'navigations',
                'view'
            ],
            [
                'navigations.create',
                'Navigations — Create',
                'navigations',
                'create'
            ],
            [
                'navigations.update',
                'Navigations — Update',
                'navigations',
                'update'
            ],
            [
                'navigations.delete',
                'Navigations — Delete',
                'navigations',
                'delete'
            ],
            [
                'navigation_items.view',
                'Navigation Items — View',
                'navigation_items',
                'view'
            ],
            [
                'navigation_items.create',
                'Navigation Items — Create',
                'navigation_items',
                'create'
            ],
            [
                'navigation_items.update',
                'Navigation Items — Update',
                'navigation_items',
                'update'
            ],
            [
                'navigation_items.delete',
                'Navigation Items — Delete',
                'navigation_items',
                'delete'
            ],
            [
                'programs.view',
                'Programs — View',
                'programs',
                'view'
            ],
            [
                'programs.create',
                'Programs — Create',
                'programs',
                'create'
            ],
            [
                'programs.update',
                'Programs — Update',
                'programs',
                'update'
            ],
            [
                'programs.delete',
                'Programs — Delete',
                'programs',
                'delete'
            ],
            [
                'programs.publish',
                'Programs — Publish',
                'programs',
                'publish'
            ],
            [
                'projects.view',
                'Projects — View',
                'projects',
                'view'
            ],
            [
                'projects.create',
                'Projects — Create',
                'projects',
                'create'
            ],
            [
                'projects.update',
                'Projects — Update',
                'projects',
                'update'
            ],
            [
                'projects.delete',
                'Projects — Delete',
                'projects',
                'delete'
            ],
            [
                'projects.publish',
                'Projects — Publish',
                'projects',
                'publish'
            ],
            [
                'project_activities.view',
                'Project Activities — View',
                'project_activities',
                'view'
            ],
            [
                'project_activities.create',
                'Project Activities — Create',
                'project_activities',
                'create'
            ],
            [
                'project_activities.update',
                'Project Activities — Update',
                'project_activities',
                'update'
            ],
            [
                'project_activities.delete',
                'Project Activities — Delete',
                'project_activities',
                'delete'
            ],
            [
                'project_metrics.view',
                'Project Metrics — View',
                'project_metrics',
                'view'
            ],
            [
                'project_metrics.create',
                'Project Metrics — Create',
                'project_metrics',
                'create'
            ],
            [
                'project_metrics.update',
                'Project Metrics — Update',
                'project_metrics',
                'update'
            ],
            [
                'project_metrics.delete',
                'Project Metrics — Delete',
                'project_metrics',
                'delete'
            ],
            [
                'project_budgets.view',
                'Project Budgets — View',
                'project_budgets',
                'view'
            ],
            [
                'project_budgets.create',
                'Project Budgets — Create',
                'project_budgets',
                'create'
            ],
            [
                'project_budgets.update',
                'Project Budgets — Update',
                'project_budgets',
                'update'
            ],
            [
                'project_budgets.delete',
                'Project Budgets — Delete',
                'project_budgets',
                'delete'
            ],
            [
                'campaigns.view',
                'Campaigns — View',
                'campaigns',
                'view'
            ],
            [
                'campaigns.create',
                'Campaigns — Create',
                'campaigns',
                'create'
            ],
            [
                'campaigns.update',
                'Campaigns — Update',
                'campaigns',
                'update'
            ],
            [
                'campaigns.delete',
                'Campaigns — Delete',
                'campaigns',
                'delete'
            ],
            [
                'campaigns.publish',
                'Campaigns — Publish',
                'campaigns',
                'publish'
            ],
            [
                'donations.view',
                'Donations — View',
                'donations',
                'view'
            ],
            [
                'donations.update',
                'Donations — Update',
                'donations',
                'update'
            ],
            [
                'payment_transactions.view',
                'Payment Transactions — View',
                'payment_transactions',
                'view'
            ],
            [
                'payment_transactions.update',
                'Payment Transactions — Update',
                'payment_transactions',
                'update'
            ],
            [
                'gallery_categories.view',
                'Gallery Categories — View',
                'gallery_categories',
                'view'
            ],
            [
                'gallery_categories.create',
                'Gallery Categories — Create',
                'gallery_categories',
                'create'
            ],
            [
                'gallery_categories.update',
                'Gallery Categories — Update',
                'gallery_categories',
                'update'
            ],
            [
                'gallery_categories.delete',
                'Gallery Categories — Delete',
                'gallery_categories',
                'delete'
            ],
            [
                'galleries.view',
                'Galleries — View',
                'galleries',
                'view'
            ],
            [
                'galleries.create',
                'Galleries — Create',
                'galleries',
                'create'
            ],
            [
                'galleries.update',
                'Galleries — Update',
                'galleries',
                'update'
            ],
            [
                'galleries.delete',
                'Galleries — Delete',
                'galleries',
                'delete'
            ],
            [
                'galleries.publish',
                'Galleries — Publish',
                'galleries',
                'publish'
            ],
            [
                'gallery_photos.view',
                'Gallery Photos — View',
                'gallery_photos',
                'view'
            ],
            [
                'gallery_photos.create',
                'Gallery Photos — Create',
                'gallery_photos',
                'create'
            ],
            [
                'gallery_photos.update',
                'Gallery Photos — Update',
                'gallery_photos',
                'update'
            ],
            [
                'gallery_photos.delete',
                'Gallery Photos — Delete',
                'gallery_photos',
                'delete'
            ],
            [
                'video_galleries.view',
                'Video Galleries — View',
                'video_galleries',
                'view'
            ],
            [
                'video_galleries.create',
                'Video Galleries — Create',
                'video_galleries',
                'create'
            ],
            [
                'video_galleries.update',
                'Video Galleries — Update',
                'video_galleries',
                'update'
            ],
            [
                'video_galleries.delete',
                'Video Galleries — Delete',
                'video_galleries',
                'delete'
            ],
            [
                'video_galleries.publish',
                'Video Galleries — Publish',
                'video_galleries',
                'publish'
            ],
            [
                'videos.view',
                'Videos — View',
                'videos',
                'view'
            ],
            [
                'videos.create',
                'Videos — Create',
                'videos',
                'create'
            ],
            [
                'videos.update',
                'Videos — Update',
                'videos',
                'update'
            ],
            [
                'videos.delete',
                'Videos — Delete',
                'videos',
                'delete'
            ],
            [
                'videos.publish',
                'Videos — Publish',
                'videos',
                'publish'
            ],
            [
                'articles.view',
                'Articles — View',
                'articles',
                'view'
            ],
            [
                'articles.create',
                'Articles — Create',
                'articles',
                'create'
            ],
            [
                'articles.update',
                'Articles — Update',
                'articles',
                'update'
            ],
            [
                'articles.delete',
                'Articles — Delete',
                'articles',
                'delete'
            ],
            [
                'articles.publish',
                'Articles — Publish',
                'articles',
                'publish'
            ],
            [
                'news.view',
                'News — View',
                'news',
                'view'
            ],
            [
                'news.create',
                'News — Create',
                'news',
                'create'
            ],
            [
                'news.update',
                'News — Update',
                'news',
                'update'
            ],
            [
                'news.delete',
                'News — Delete',
                'news',
                'delete'
            ],
            [
                'news.publish',
                'News — Publish',
                'news',
                'publish'
            ],
            [
                'sponsored_children.view',
                'Sponsored Children — View',
                'sponsored_children',
                'view'
            ],
            [
                'sponsored_children.create',
                'Sponsored Children — Create',
                'sponsored_children',
                'create'
            ],
            [
                'sponsored_children.update',
                'Sponsored Children — Update',
                'sponsored_children',
                'update'
            ],
            [
                'sponsored_children.delete',
                'Sponsored Children — Delete',
                'sponsored_children',
                'delete'
            ],
            [
                'sponsorships.view',
                'Sponsorships — View',
                'sponsorships',
                'view'
            ],
            [
                'sponsorships.create',
                'Sponsorships — Create',
                'sponsorships',
                'create'
            ],
            [
                'sponsorships.update',
                'Sponsorships — Update',
                'sponsorships',
                'update'
            ],
            [
                'volunteer_applications.view',
                'Volunteer Applications — View',
                'volunteer_applications',
                'view'
            ],
            [
                'volunteer_applications.update',
                'Volunteer Applications — Update',
                'volunteer_applications',
                'update'
            ],
            [
                'volunteer_applications.delete',
                'Volunteer Applications — Delete',
                'volunteer_applications',
                'delete'
            ],
            [
                'events.view',
                'Events — View',
                'events',
                'view'
            ],
            [
                'events.create',
                'Events — Create',
                'events',
                'create'
            ],
            [
                'events.update',
                'Events — Update',
                'events',
                'update'
            ],
            [
                'events.delete',
                'Events — Delete',
                'events',
                'delete'
            ],
            [
                'events.publish',
                'Events — Publish',
                'events',
                'publish'
            ],
            [
                'faq_categories.view',
                'Faq Categories — View',
                'faq_categories',
                'view'
            ],
            [
                'faq_categories.create',
                'Faq Categories — Create',
                'faq_categories',
                'create'
            ],
            [
                'faq_categories.update',
                'Faq Categories — Update',
                'faq_categories',
                'update'
            ],
            [
                'faq_categories.delete',
                'Faq Categories — Delete',
                'faq_categories',
                'delete'
            ],
            [
                'faqs.view',
                'Faqs — View',
                'faqs',
                'view'
            ],
            [
                'faqs.create',
                'Faqs — Create',
                'faqs',
                'create'
            ],
            [
                'faqs.update',
                'Faqs — Update',
                'faqs',
                'update'
            ],
            [
                'faqs.delete',
                'Faqs — Delete',
                'faqs',
                'delete'
            ],
            [
                'faqs.publish',
                'Faqs — Publish',
                'faqs',
                'publish'
            ],
            [
                'resources.view',
                'Resources — View',
                'resources',
                'view'
            ],
            [
                'resources.create',
                'Resources — Create',
                'resources',
                'create'
            ],
            [
                'resources.update',
                'Resources — Update',
                'resources',
                'update'
            ],
            [
                'resources.delete',
                'Resources — Delete',
                'resources',
                'delete'
            ],
            [
                'resources.publish',
                'Resources — Publish',
                'resources',
                'publish'
            ],
            [
                'people.view',
                'People — View',
                'people',
                'view'
            ],
            [
                'people.create',
                'People — Create',
                'people',
                'create'
            ],
            [
                'people.update',
                'People — Update',
                'people',
                'update'
            ],
            [
                'people.delete',
                'People — Delete',
                'people',
                'delete'
            ],
            [
                'partners.view',
                'Partners — View',
                'partners',
                'view'
            ],
            [
                'partners.create',
                'Partners — Create',
                'partners',
                'create'
            ],
            [
                'partners.update',
                'Partners — Update',
                'partners',
                'update'
            ],
            [
                'partners.delete',
                'Partners — Delete',
                'partners',
                'delete'
            ],
            [
                'contact_submissions.view',
                'Contact Submissions — View',
                'contact_submissions',
                'view'
            ],
            [
                'contact_submissions.update',
                'Contact Submissions — Update',
                'contact_submissions',
                'update'
            ],
            [
                'contact_submissions.delete',
                'Contact Submissions — Delete',
                'contact_submissions',
                'delete'
            ],
            [
                'media.view',
                'Media — View',
                'media',
                'view'
            ],
            [
                'media.create',
                'Media — Create',
                'media',
                'create'
            ],
            [
                'media.update',
                'Media — Update',
                'media',
                'update'
            ],
            [
                'media.delete',
                'Media — Delete',
                'media',
                'delete'
            ],
            [
                'site_settings.view',
                'Site Settings — View',
                'site_settings',
                'view'
            ],
            [
                'site_settings.update',
                'Site Settings — Update',
                'site_settings',
                'update'
            ],
            [
                'audit_logs.view',
                'Audit Logs — View',
                'audit_logs',
                'view'
            ]
        ];

        foreach ($permissionDefinitions as [$slug, $name, $module, $action]) {
            Permission::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'module' => $module,
                    'action' => $action,
                    'description' => $name . ' permission for the ' . $module . ' module.',
                ]
            );
        }

        $this->syncRolePermissions('super-admin', [
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
            'permissions.view',
            'permissions.create',
            'permissions.update',
            'permissions.delete',
            'pages.view',
            'pages.create',
            'pages.update',
            'pages.delete',
            'pages.publish',
            'page_sections.view',
            'page_sections.create',
            'page_sections.update',
            'page_sections.delete',
            'page_sections.publish',
            'navigations.view',
            'navigations.create',
            'navigations.update',
            'navigations.delete',
            'navigation_items.view',
            'navigation_items.create',
            'navigation_items.update',
            'navigation_items.delete',
            'programs.view',
            'programs.create',
            'programs.update',
            'programs.delete',
            'programs.publish',
            'projects.view',
            'projects.create',
            'projects.update',
            'projects.delete',
            'projects.publish',
            'project_activities.view',
            'project_activities.create',
            'project_activities.update',
            'project_activities.delete',
            'project_metrics.view',
            'project_metrics.create',
            'project_metrics.update',
            'project_metrics.delete',
            'project_budgets.view',
            'project_budgets.create',
            'project_budgets.update',
            'project_budgets.delete',
            'campaigns.view',
            'campaigns.create',
            'campaigns.update',
            'campaigns.delete',
            'campaigns.publish',
            'donations.view',
            'donations.update',
            'payment_transactions.view',
            'payment_transactions.update',
            'gallery_categories.view',
            'gallery_categories.create',
            'gallery_categories.update',
            'gallery_categories.delete',
            'galleries.view',
            'galleries.create',
            'galleries.update',
            'galleries.delete',
            'galleries.publish',
            'gallery_photos.view',
            'gallery_photos.create',
            'gallery_photos.update',
            'gallery_photos.delete',
            'video_galleries.view',
            'video_galleries.create',
            'video_galleries.update',
            'video_galleries.delete',
            'video_galleries.publish',
            'videos.view',
            'videos.create',
            'videos.update',
            'videos.delete',
            'videos.publish',
            'articles.view',
            'articles.create',
            'articles.update',
            'articles.delete',
            'articles.publish',
            'news.view',
            'news.create',
            'news.update',
            'news.delete',
            'news.publish',
            'sponsored_children.view',
            'sponsored_children.create',
            'sponsored_children.update',
            'sponsored_children.delete',
            'sponsorships.view',
            'sponsorships.create',
            'sponsorships.update',
            'volunteer_applications.view',
            'volunteer_applications.update',
            'volunteer_applications.delete',
            'events.view',
            'events.create',
            'events.update',
            'events.delete',
            'events.publish',
            'faq_categories.view',
            'faq_categories.create',
            'faq_categories.update',
            'faq_categories.delete',
            'faqs.view',
            'faqs.create',
            'faqs.update',
            'faqs.delete',
            'faqs.publish',
            'resources.view',
            'resources.create',
            'resources.update',
            'resources.delete',
            'resources.publish',
            'people.view',
            'people.create',
            'people.update',
            'people.delete',
            'partners.view',
            'partners.create',
            'partners.update',
            'partners.delete',
            'contact_submissions.view',
            'contact_submissions.update',
            'contact_submissions.delete',
            'media.view',
            'media.create',
            'media.update',
            'media.delete',
            'site_settings.view',
            'site_settings.update',
            'audit_logs.view'
        ]);
        $this->syncRolePermissions('admin', [
            'pages.view',
            'pages.create',
            'pages.update',
            'pages.delete',
            'pages.publish',
            'page_sections.view',
            'page_sections.create',
            'page_sections.update',
            'page_sections.delete',
            'page_sections.publish',
            'navigations.view',
            'navigations.create',
            'navigations.update',
            'navigations.delete',
            'navigation_items.view',
            'navigation_items.create',
            'navigation_items.update',
            'navigation_items.delete',
            'programs.view',
            'programs.create',
            'programs.update',
            'programs.delete',
            'programs.publish',
            'projects.view',
            'projects.create',
            'projects.update',
            'projects.delete',
            'projects.publish',
            'project_activities.view',
            'project_activities.create',
            'project_activities.update',
            'project_activities.delete',
            'project_metrics.view',
            'project_metrics.create',
            'project_metrics.update',
            'project_metrics.delete',
            'project_budgets.view',
            'project_budgets.create',
            'project_budgets.update',
            'project_budgets.delete',
            'campaigns.view',
            'campaigns.create',
            'campaigns.update',
            'campaigns.delete',
            'campaigns.publish',
            'donations.view',
            'donations.update',
            'payment_transactions.view',
            'payment_transactions.update',
            'gallery_categories.view',
            'gallery_categories.create',
            'gallery_categories.update',
            'gallery_categories.delete',
            'galleries.view',
            'galleries.create',
            'galleries.update',
            'galleries.delete',
            'galleries.publish',
            'gallery_photos.view',
            'gallery_photos.create',
            'gallery_photos.update',
            'gallery_photos.delete',
            'video_galleries.view',
            'video_galleries.create',
            'video_galleries.update',
            'video_galleries.delete',
            'video_galleries.publish',
            'videos.view',
            'videos.create',
            'videos.update',
            'videos.delete',
            'videos.publish',
            'articles.view',
            'articles.create',
            'articles.update',
            'articles.delete',
            'articles.publish',
            'news.view',
            'news.create',
            'news.update',
            'news.delete',
            'news.publish',
            'sponsored_children.view',
            'sponsored_children.create',
            'sponsored_children.update',
            'sponsored_children.delete',
            'sponsorships.view',
            'sponsorships.create',
            'sponsorships.update',
            'volunteer_applications.view',
            'volunteer_applications.update',
            'volunteer_applications.delete',
            'events.view',
            'events.create',
            'events.update',
            'events.delete',
            'events.publish',
            'faq_categories.view',
            'faq_categories.create',
            'faq_categories.update',
            'faq_categories.delete',
            'faqs.view',
            'faqs.create',
            'faqs.update',
            'faqs.delete',
            'faqs.publish',
            'resources.view',
            'resources.create',
            'resources.update',
            'resources.delete',
            'resources.publish',
            'people.view',
            'people.create',
            'people.update',
            'people.delete',
            'partners.view',
            'partners.create',
            'partners.update',
            'partners.delete',
            'contact_submissions.view',
            'contact_submissions.update',
            'contact_submissions.delete',
            'media.view',
            'media.create',
            'media.update',
            'media.delete'
        ]);
        $this->syncRolePermissions('content-manager', [
            'pages.view',
            'pages.create',
            'pages.update',
            'pages.delete',
            'page_sections.view',
            'page_sections.create',
            'page_sections.update',
            'page_sections.delete',
            'navigations.view',
            'navigations.create',
            'navigations.update',
            'navigations.delete',
            'navigation_items.view',
            'navigation_items.create',
            'navigation_items.update',
            'navigation_items.delete',
            'programs.view',
            'programs.create',
            'programs.update',
            'programs.delete',
            'projects.view',
            'projects.create',
            'projects.update',
            'projects.delete',
            'project_activities.view',
            'project_activities.create',
            'project_activities.update',
            'project_activities.delete',
            'project_metrics.view',
            'project_metrics.create',
            'project_metrics.update',
            'project_metrics.delete',
            'gallery_categories.view',
            'gallery_categories.create',
            'gallery_categories.update',
            'gallery_categories.delete',
            'galleries.view',
            'galleries.create',
            'galleries.update',
            'galleries.delete',
            'gallery_photos.view',
            'gallery_photos.create',
            'gallery_photos.update',
            'gallery_photos.delete',
            'video_galleries.view',
            'video_galleries.create',
            'video_galleries.update',
            'video_galleries.delete',
            'videos.view',
            'videos.create',
            'videos.update',
            'videos.delete',
            'articles.view',
            'articles.create',
            'articles.update',
            'articles.delete',
            'news.view',
            'news.create',
            'news.update',
            'news.delete',
            'events.view',
            'events.create',
            'events.update',
            'events.delete',
            'faq_categories.view',
            'faq_categories.create',
            'faq_categories.update',
            'faq_categories.delete',
            'faqs.view',
            'faqs.create',
            'faqs.update',
            'faqs.delete',
            'resources.view',
            'resources.create',
            'resources.update',
            'resources.delete',
            'people.view',
            'people.create',
            'people.update',
            'people.delete',
            'partners.view',
            'partners.create',
            'partners.update',
            'partners.delete',
            'media.view',
            'media.create',
            'media.update',
            'media.delete'
        ]);
        $this->syncRolePermissions('finance-manager', [
            'campaigns.view',
            'campaigns.create',
            'campaigns.update',
            'donations.view',
            'donations.update',
            'payment_transactions.view',
            'payment_transactions.update'
        ]);
    }

    private function syncRolePermissions(string $roleSlug, array $permissionSlugs): void
    {
        $role = Role::where('slug', $roleSlug)->firstOrFail();

        $permissionIds = Permission::whereIn('slug', $permissionSlugs)
            ->pluck('id')
            ->all();

        $role->permissions()->sync($permissionIds);
    }
}
