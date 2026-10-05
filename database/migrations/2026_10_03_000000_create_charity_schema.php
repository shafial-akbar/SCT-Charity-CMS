<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        Schema::create('roles', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('name', 100)->unique();
            $t->string('slug', 100)->unique();
            $t->text('description')->nullable();
            $t->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | User Roles
        |--------------------------------------------------------------------------
        */

        Schema::create('user_roles', function (Blueprint $t) {
            $t->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $t->uuid('role_id');

            $t->primary(['user_id', 'role_id']);

            $t->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->cascadeOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Media
        |--------------------------------------------------------------------------
        */

        Schema::create('media', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->foreignId('uploaded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $t->string('file_name');
            $t->string('original_name')->nullable();
            $t->text('file_path');
            $t->string('disk', 50)->default('public');
            $t->string('mime_type', 100)->nullable();
            $t->unsignedBigInteger('file_size')->nullable();

            // Bilingual media metadata
            $t->string('alt_text_en')->nullable();
            $t->string('alt_text_bn')->nullable();
            $t->string('title_en')->nullable();
            $t->string('title_bn')->nullable();
            $t->text('caption_en')->nullable();
            $t->text('caption_bn')->nullable();

            $t->json('metadata')->nullable();

            $t->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Pages
        |--------------------------------------------------------------------------
        */

        Schema::create('pages', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('parent_id')->nullable();

            // Bilingual content
            $t->string('title_en');
            $t->string('title_bn')->nullable();

            // URL
            $t->string('slug')->unique();

            $t->string('page_type', 50)->default('standard');

            $t->text('short_description_en')->nullable();
            $t->text('short_description_bn')->nullable();

            $t->enum('status', [
                'draft',
                'published',
                'archived'
            ])->default('draft');

            // SEO
            $t->string('seo_title_en')->nullable();
            $t->string('seo_title_bn')->nullable();

            $t->text('seo_description_en')->nullable();
            $t->text('seo_description_bn')->nullable();

            $t->integer('sort_order')->default(0);

            $t->timestamp('published_at')->nullable();

            $t->timestamps();

            $t->foreign('parent_id')
                ->references('id')
                ->on('pages')
                ->nullOnDelete();
        });
        
        /*
        |--------------------------------------------------------------------------
        | Page Sections
        |--------------------------------------------------------------------------
        */

        Schema::create('page_sections', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('page_id');

            $t->string('section_type', 100);

            $t->string('title_en')->nullable();
            $t->string('title_bn')->nullable();

            $t->string('subtitle_en')->nullable();
            $t->string('subtitle_bn')->nullable();

            $t->longText('content_en')->nullable();
            $t->longText('content_bn')->nullable();

            $t->uuid('media_id')->nullable();

            /*
             * Flexible section-specific configuration.
             *
             * Example:
             * {
             *   "button": {
             *      "text_en": "Learn More",
             *      "text_bn": "আরও জানুন",
             *      "url": "/about-us"
             *   }
             * }
             */
            $t->json('data')->nullable();

            $t->integer('sort_order')->default(0);

            $t->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $t->timestamps();

            $t->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->cascadeOnDelete();

            $t->foreign('media_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Navigation
        |--------------------------------------------------------------------------
        */

        Schema::create('navigations', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('name', 100);
            $t->string('slug', 100)->unique();

            $t->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $t->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Navigation Items
        |--------------------------------------------------------------------------
        */

        Schema::create('navigation_items', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('navigation_id');
            $t->uuid('parent_id')->nullable();

            $t->string('title_en');
            $t->string('title_bn');

            $t->enum('link_type', [
                'page',
                'url',
            ])->default('page');

            $t->uuid('page_id')->nullable();

            $t->text('url')->nullable();

            $t->enum('target', [
                '_self',
                '_blank',
            ])->default('_self');

            $t->integer('sort_order')->default(0);

            $t->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $t->timestamps();

            $t->foreign('navigation_id')
                ->references('id')
                ->on('navigations')
                ->cascadeOnDelete();

            $t->foreign('parent_id')
                ->references('id')
                ->on('navigation_items')
                ->cascadeOnDelete();

            $t->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Programs
        |--------------------------------------------------------------------------
        */

        Schema::create('programs', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('title_en');
            $t->string('title_bn');

            $t->string('slug_en')->unique();
            $t->string('slug_bn')->unique();

            $t->text('short_description_en')->nullable();
            $t->text('short_description_bn')->nullable();

            $t->longText('description_en')->nullable();
            $t->longText('description_bn')->nullable();

            $t->uuid('featured_image_id')->nullable();

            $t->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $t->integer('sort_order')->default(0);

            $t->string('seo_title_en')->nullable();
            $t->string('seo_title_bn')->nullable();

            $t->text('seo_description_en')->nullable();
            $t->text('seo_description_bn')->nullable();

            $t->timestamp('published_at')->nullable();

            $t->timestamps();

            $t->foreign('featured_image_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Projects
        |--------------------------------------------------------------------------
        */

        Schema::create('projects', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('program_id')->nullable();

            $t->string('title_en');
            $t->string('title_bn');

            $t->string('slug_en')->unique();
            $t->string('slug_bn')->unique();

            $t->text('short_description_en')->nullable();
            $t->text('short_description_bn')->nullable();

            $t->longText('description_en')->nullable();
            $t->longText('description_bn')->nullable();

            $t->uuid('featured_image_id')->nullable();

            $t->string('location_en')->nullable();
            $t->string('location_bn')->nullable();

            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();

            $t->enum('status', [
                'draft',
                'planned',
                'active',
                'completed',
                'archived',
            ])->default('draft');

            $t->string('seo_title_en')->nullable();
            $t->string('seo_title_bn')->nullable();

            $t->text('seo_description_en')->nullable();
            $t->text('seo_description_bn')->nullable();

            $t->timestamp('published_at')->nullable();

            $t->timestamps();

            $t->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->nullOnDelete();

            $t->foreign('featured_image_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Project Activities
        |--------------------------------------------------------------------------
        */

        Schema::create('project_activities', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('project_id');

            $t->string('title_en');
            $t->string('title_bn');

            $t->text('description_en')->nullable();
            $t->text('description_bn')->nullable();

            $t->date('activity_date')->nullable();

            $t->string('location_en')->nullable();
            $t->string('location_bn')->nullable();

            $t->enum('status', [
                'planned',
                'completed',
                'cancelled',
            ])->default('planned');

            $t->integer('sort_order')->default(0);

            $t->timestamps();

            $t->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Project Metrics
        |--------------------------------------------------------------------------
        */

        Schema::create('project_metrics', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('project_id');

            $t->string('metric_name_en', 150);
            $t->string('metric_name_bn', 150);

            $t->string('metric_value', 100);
            $t->string('metric_unit', 100)->nullable();

            $t->text('description_en')->nullable();
            $t->text('description_bn')->nullable();

            $t->integer('sort_order')->default(0);

            $t->timestamps();

            $t->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Project Budgets
        |--------------------------------------------------------------------------
        */

        Schema::create('project_budgets', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('project_id');

            $t->string('category_en', 150);
            $t->string('category_bn', 150);

            $t->text('description_en')->nullable();
            $t->text('description_bn')->nullable();

            $t->decimal('allocated_amount', 15, 2)->default(0);
            $t->decimal('spent_amount', 15, 2)->default(0);

            $t->char('currency', 3)->default('BDT');

            $t->integer('sort_order')->default(0);

            $t->timestamps();

            $t->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | People
        |--------------------------------------------------------------------------
        */

        Schema::create('people', function (Blueprint $t) {
            $t->uuid('id')->primary();

            // Person's actual name is language-neutral.
            $t->string('name');

            $t->string('designation_en')->nullable();
            $t->string('designation_bn')->nullable();

            $t->longText('biography_en')->nullable();
            $t->longText('biography_bn')->nullable();

            $t->uuid('photo_id')->nullable();

            $t->string('email')->nullable();
            $t->string('phone', 50)->nullable();

            $t->json('social_links')->nullable();

            $t->integer('sort_order')->default(0);

            $t->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $t->timestamps();

            $t->foreign('photo_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Partners
        |--------------------------------------------------------------------------
        */

        Schema::create('partners', function (Blueprint $t) {
            $t->uuid('id')->primary();

            // Official organization name.
            $t->string('name');

            $t->string('slug_en')->nullable()->unique();
            $t->string('slug_bn')->nullable()->unique();

            $t->text('description_en')->nullable();
            $t->text('description_bn')->nullable();

            $t->uuid('logo_id')->nullable();

            $t->string('website_url', 500)->nullable();

            $t->string('partner_type', 100)->nullable();

            $t->integer('sort_order')->default(0);

            $t->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $t->timestamps();

            $t->foreign('logo_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Resources
        |--------------------------------------------------------------------------
        */

        Schema::create('resources', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('title_en');
            $t->string('title_bn');

            $t->string('slug_en')->nullable()->unique();
            $t->string('slug_bn')->nullable()->unique();

            $t->text('description_en')->nullable();
            $t->text('description_bn')->nullable();

            $t->string('resource_type', 100)->nullable();

            $t->uuid('file_id')->nullable();

            $t->date('publication_date')->nullable();

            $t->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $t->string('seo_title_en')->nullable();
            $t->string('seo_title_bn')->nullable();

            $t->text('seo_description_en')->nullable();
            $t->text('seo_description_bn')->nullable();

            $t->timestamps();

            $t->foreign('file_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Articles
        |--------------------------------------------------------------------------
        */

        Schema::create('articles', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('title_en');
            $t->string('title_bn');

            $t->string('slug_en')->unique();
            $t->string('slug_bn')->unique();

            $t->text('excerpt_en')->nullable();
            $t->text('excerpt_bn')->nullable();

            $t->longText('body_en');
            $t->longText('body_bn');

            $t->uuid('featured_image_id')->nullable();
            $t->uuid('author_id')->nullable();

            $t->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $t->timestamp('published_at')->nullable();

            $t->string('seo_title_en')->nullable();
            $t->string('seo_title_bn')->nullable();

            $t->text('seo_description_en')->nullable();
            $t->text('seo_description_bn')->nullable();

            $t->timestamps();

            $t->foreign('author_id')
                ->references('id')
                ->on('people')
                ->nullOnDelete();

            $t->foreign('featured_image_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | News
        |--------------------------------------------------------------------------
        */

        Schema::create('news', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('title_en');
            $t->string('title_bn');

            $t->string('slug_en')->unique();
            $t->string('slug_bn')->unique();

            $t->text('excerpt_en')->nullable();
            $t->text('excerpt_bn')->nullable();

            $t->longText('body_en');
            $t->longText('body_bn');

            $t->uuid('featured_image_id')->nullable();
            $t->uuid('author_id')->nullable();

            $t->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $t->timestamp('published_at')->nullable();

            $t->string('seo_title_en')->nullable();
            $t->string('seo_title_bn')->nullable();

            $t->text('seo_description_en')->nullable();
            $t->text('seo_description_bn')->nullable();

            $t->timestamps();

            $t->foreign('author_id')
                ->references('id')
                ->on('people')
                ->nullOnDelete();

            $t->foreign('featured_image_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | FAQ Categories
        |--------------------------------------------------------------------------
        */

        Schema::create('faq_categories', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('name_en', 150);
            $t->string('name_bn', 150);

            $t->string('slug_en', 150)->unique();
            $t->string('slug_bn', 150)->unique();

            $t->text('description_en')->nullable();
            $t->text('description_bn')->nullable();

            $t->integer('sort_order')->default(0);

            $t->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $t->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | FAQs
        |--------------------------------------------------------------------------
        */

        Schema::create('faqs', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('category_id')->nullable();

            $t->text('question_en');
            $t->text('question_bn');

            $t->longText('answer_en');
            $t->longText('answer_bn');

            $t->integer('sort_order')->default(0);

            $t->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $t->timestamps();

            $t->foreign('category_id')
                ->references('id')
                ->on('faq_categories')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Gallery Categories
        |--------------------------------------------------------------------------
        */

        Schema::create('gallery_categories', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('name_en', 150);
            $t->string('name_bn', 150);

            $t->string('slug_en', 150)->unique();
            $t->string('slug_bn', 150)->unique();

            $t->text('description_en')->nullable();
            $t->text('description_bn')->nullable();

            $t->integer('sort_order')->default(0);

            $t->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $t->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Galleries
        |--------------------------------------------------------------------------
        */

        Schema::create('galleries', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('category_id')->nullable();

            $t->string('title_en');
            $t->string('title_bn');

            $t->string('slug_en')->unique();
            $t->string('slug_bn')->unique();

            $t->text('description_en')->nullable();
            $t->text('description_bn')->nullable();

            $t->uuid('cover_image_id')->nullable();

            $t->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $t->timestamp('published_at')->nullable();

            $t->timestamps();

            $t->foreign('category_id')
                ->references('id')
                ->on('gallery_categories')
                ->nullOnDelete();

            $t->foreign('cover_image_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Gallery Photos
        |--------------------------------------------------------------------------
        */

        Schema::create('gallery_photos', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('gallery_id');
            $t->uuid('media_id');

            $t->text('caption_en')->nullable();
            $t->text('caption_bn')->nullable();

            $t->string('alt_text_en')->nullable();
            $t->string('alt_text_bn')->nullable();

            $t->integer('sort_order')->default(0);

            $t->timestamps();

            $t->foreign('gallery_id')
                ->references('id')
                ->on('galleries')
                ->cascadeOnDelete();

            $t->foreign('media_id')
                ->references('id')
                ->on('media')
                ->cascadeOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Video Galleries
        |--------------------------------------------------------------------------
        */

        Schema::create('video_galleries', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('title_en');
            $t->string('title_bn');

            $t->string('slug_en')->unique();
            $t->string('slug_bn')->unique();

            $t->text('description_en')->nullable();
            $t->text('description_bn')->nullable();

            $t->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $t->timestamp('published_at')->nullable();

            $t->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Videos
        |--------------------------------------------------------------------------
        */

        Schema::create('videos', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('gallery_id')->nullable();

            $t->string('title_en');
            $t->string('title_bn');

            $t->string('slug_en')->nullable()->unique();
            $t->string('slug_bn')->nullable()->unique();

            $t->text('description_en')->nullable();
            $t->text('description_bn')->nullable();

            $t->string('video_provider', 50)->nullable();
            $t->string('video_url', 500);
            $t->string('video_id')->nullable();

            $t->uuid('thumbnail_id')->nullable();

            $t->timestamp('published_at')->nullable();

            $t->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $t->integer('sort_order')->default(0);

            $t->timestamps();

            $t->foreign('gallery_id')
                ->references('id')
                ->on('video_galleries')
                ->nullOnDelete();

            $t->foreign('thumbnail_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Events
        |--------------------------------------------------------------------------
        */

        Schema::create('events', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('title_en');
            $t->string('title_bn');

            $t->string('slug_en')->unique();
            $t->string('slug_bn')->unique();

            $t->longText('description_en')->nullable();
            $t->longText('description_bn')->nullable();

            $t->uuid('featured_image_id')->nullable();

            $t->string('location_en', 500)->nullable();
            $t->string('location_bn', 500)->nullable();

            $t->dateTime('start_at')->nullable();
            $t->dateTime('end_at')->nullable();

            $t->string('registration_url', 500)->nullable();

            $t->enum('status', [
                'draft',
                'upcoming',
                'ongoing',
                'completed',
                'cancelled',
                'archived',
            ])->default('draft');

            $t->timestamp('published_at')->nullable();

            $t->string('seo_title_en')->nullable();
            $t->string('seo_title_bn')->nullable();

            $t->text('seo_description_en')->nullable();
            $t->text('seo_description_bn')->nullable();

            $t->timestamps();

            $t->foreign('featured_image_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Volunteer Applications
        |--------------------------------------------------------------------------
        */

        Schema::create('volunteer_applications', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('name');
            $t->string('email');
            $t->string('phone', 50)->nullable();
            $t->text('address')->nullable();
            $t->string('occupation')->nullable();
            $t->text('skills')->nullable();
            $t->text('interests')->nullable();
            $t->text('message')->nullable();

            $t->enum('status', [
                'pending',
                'reviewing',
                'approved',
                'rejected',
                'archived',
            ])->default('pending');

            $t->text('admin_notes')->nullable();

            $t->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $t->timestamp('reviewed_at')->nullable();

            $t->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Campaigns
        |--------------------------------------------------------------------------
        */

        Schema::create('campaigns', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('project_id')->nullable();
            $t->uuid('program_id')->nullable();

            $t->string('title_en');
            $t->string('title_bn');

            $t->string('slug_en')->unique();
            $t->string('slug_bn')->unique();

            $t->text('short_description_en')->nullable();
            $t->text('short_description_bn')->nullable();

            $t->longText('description_en')->nullable();
            $t->longText('description_bn')->nullable();

            $t->uuid('featured_image_id')->nullable();

            $t->decimal('target_amount', 15, 2)->nullable();
            $t->char('currency', 3)->default('BDT');

            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();

            $t->enum('status', [
                'draft',
                'active',
                'completed',
                'cancelled',
                'archived',
            ])->default('draft');

            $t->boolean('is_featured')->default(false);

            $t->string('seo_title_en')->nullable();
            $t->string('seo_title_bn')->nullable();

            $t->text('seo_description_en')->nullable();
            $t->text('seo_description_bn')->nullable();

            $t->timestamp('published_at')->nullable();

            $t->timestamps();

            $t->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->nullOnDelete();

            $t->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->nullOnDelete();

            $t->foreign('featured_image_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Donations
        |--------------------------------------------------------------------------
        */

        Schema::create('donations', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('campaign_id')->nullable();

            $t->string('donor_name')->nullable();
            $t->string('donor_email')->nullable();
            $t->string('donor_phone', 50)->nullable();

            $t->decimal('amount', 15, 2);

            $t->char('currency', 3)->default('BDT');

            $t->string('payment_method', 50)->nullable();

            $t->boolean('is_anonymous')->default(false);

            $t->text('message')->nullable();

            $t->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'cancelled',
                'refunded',
            ])->default('pending');

            $t->timestamps();

            $t->foreign('campaign_id')
                ->references('id')
                ->on('campaigns')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Payment Transactions
        |--------------------------------------------------------------------------
        */

        Schema::create('payment_transactions', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('donation_id');

            $t->string('gateway', 100);
            $t->string('transaction_id')->nullable();
            $t->string('gateway_transaction_id')->nullable();
            $t->string('payment_method', 100)->nullable();

            $t->decimal('amount', 15, 2);
            $t->char('currency', 3)->default('BDT');

            $t->enum('status', [
                'initiated',
                'pending',
                'success',
                'failed',
                'cancelled',
                'refunded',
            ])->default('initiated');

            $t->json('gateway_response')->nullable();

            $t->timestamp('paid_at')->nullable();

            $t->timestamps();

            $t->unique(['gateway', 'transaction_id']);

            $t->foreign('donation_id')
                ->references('id')
                ->on('donations')
                ->cascadeOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Sponsored Children
        |--------------------------------------------------------------------------
        */

        Schema::create('sponsored_children', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('child_code', 100)->unique();

            $t->string('display_name');

            $t->unsignedInteger('age')->nullable();

            $t->string('gender', 50)->nullable();

            $t->text('short_bio_en')->nullable();
            $t->text('short_bio_bn')->nullable();

            $t->uuid('photo_id')->nullable();

            $t->string('location')->nullable();

            $t->enum('status', [
                'available',
                'sponsored',
                'inactive',
            ])->default('available');

            $t->timestamps();

            $t->foreign('photo_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Sponsorships
        |--------------------------------------------------------------------------
        */

        Schema::create('sponsorships', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->uuid('child_id');

            $t->string('sponsor_name');
            $t->string('sponsor_email')->nullable();
            $t->string('sponsor_phone', 50)->nullable();

            $t->decimal('amount', 15, 2)->nullable();
            $t->char('currency', 3)->default('BDT');

            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();

            $t->enum('status', [
                'pending',
                'active',
                'completed',
                'cancelled',
            ])->default('pending');

            $t->text('admin_notes')->nullable();

            $t->timestamps();

            $t->foreign('child_id')
                ->references('id')
                ->on('sponsored_children')
                ->restrictOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | Contact Submissions
        |--------------------------------------------------------------------------
        */

        Schema::create('contact_submissions', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('name');
            $t->string('email');
            $t->string('phone', 50)->nullable();

            $t->string('subject')->nullable();
            $t->text('message');

            $t->enum('status', [
                'unread',
                'read',
                'replied',
                'archived',
            ])->default('unread');

            $t->text('admin_notes')->nullable();

            $t->foreignId('handled_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $t->timestamp('handled_at')->nullable();

            $t->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Site Settings
        |--------------------------------------------------------------------------
        */

        Schema::create('site_settings', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('setting_key', 150)->unique();

            /*
             * For bilingual text settings, setting_value can contain:
             *
             * {
             *     "en": "English value",
             *     "bn": "বাংলা value"
             * }
             *
             * For language-neutral settings, the same field can contain
             * the normal scalar/JSON value.
             */
            $t->text('setting_value')->nullable();

            $t->enum('setting_type', [
                'text',
                'textarea',
                'number',
                'boolean',
                'json',
                'image',
                'url',
            ])->default('text');

            $t->boolean('is_public')->default(true);

            $t->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Idempotency Keys
        |--------------------------------------------------------------------------
        */

        Schema::create('idempotency_keys', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->string('idempotency_key')->unique();

            $t->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $t->string('endpoint');

            $t->string('request_hash')->nullable();

            $t->integer('response_status')->nullable();

            $t->json('response_body')->nullable();

            $t->timestamp('expires_at')->nullable();

            $t->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Audit Logs
        |--------------------------------------------------------------------------
        */

        Schema::create('audit_logs', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $t->string('action', 100);

            $t->string('entity_type', 100)->nullable();

            $t->uuid('entity_id')->nullable();

            $t->json('old_values')->nullable();
            $t->json('new_values')->nullable();

            $t->string('ip_address', 45)->nullable();

            $t->text('user_agent')->nullable();

            $t->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        foreach ([
            'audit_logs',
            'idempotency_keys',
            'site_settings',
            'contact_submissions',
            'sponsorships',
            'sponsored_children',
            'payment_transactions',
            'donations',
            'campaigns',
            'volunteer_applications',
            'events',
            'videos',
            'video_galleries',
            'gallery_photos',
            'galleries',
            'gallery_categories',
            'faqs',
            'faq_categories',
            'news',
            'articles',
            'resources',
            'partners',
            'people',
            'project_budgets',
            'project_metrics',
            'project_activities',
            'projects',
            'programs',
            'navigation_items',
            'navigations',
            'page_sections',
            'pages',
            'media',
            'user_roles',
            'roles',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};