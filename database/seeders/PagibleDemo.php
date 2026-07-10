<?php

/**
 * @license MIT, https://opensource.org/license/mit
 */


namespace Database\Seeders;

use Aimeos\Cms\Models\Element;
use Aimeos\Cms\Models\File;
use Aimeos\Cms\Models\Page;
use Aimeos\Cms\Utils;
use Illuminate\Support\Str;


/**
 * Pagible theme demo content for the PagibleAI CMS product site.
 */
class PagibleDemo extends AbstractDemo
{
    /**
     * Curated Unsplash photos used across the Pagible demo.
     *
     * @var array<string, array{0: string, 1: string, 2: string}>
     */
    private const PHOTOS = [
        'api' => ['photo-1558494949-ef010cbdcc31', 'Content delivery infrastructure', 'Server infrastructure used to deliver content through web APIs'],
        'content' => ['photo-1497366811353-6870744d04b2', 'Structured content planning', 'Editorial workspace prepared for structured content planning'],
        'editor' => ['photo-1498050108023-c5249f4df085', 'PagibleAI editing workspace', 'Developer and editor workspace for building a Laravel website'],
        'global' => ['photo-1451187580459-43490279c0fa', 'Global publishing network', 'Connected network representing multilingual content delivery'],
        'media' => ['photo-1488590528505-98d2b5aba04b', 'Media library', 'Digital media workspace with connected hardware'],
        'model' => ['photo-1518770660439-4636190af475', 'Content model', 'Detailed system architecture representing a structured content model'],
        'publish' => ['photo-1450101499163-c8848c66ca85', 'Publishing review', 'Documents and notes prepared for an editorial publishing review'],
        'search' => ['photo-1551288049-bebda4e38f71', 'Content search', 'Search and reporting interface displayed on a laptop'],
        'security' => ['photo-1563986768609-322da13575f3', 'CMS access controls', 'Security controls used to protect an editorial workspace'],
        'team' => ['photo-1521737711867-e3b97375f902', 'Editorial team', 'Editorial and development team reviewing a website together'],
        'version' => ['photo-1556075798-4825dfaaf498', 'Content version history', 'Version history displayed in a development workspace'],
        'workflow' => ['photo-1552664730-d307ca884978', 'Editorial workflow', 'Team discussing an editorial workflow around a shared table'],
    ];

    private string $element;
    private string $guideFile;


    /**
     * Creates the journal section below the home page.
     *
     * @param Page $home Home page
     * @param string $blogId Journal page ID referenced by listing elements
     * @return static Same object for fluent calls
     */
    protected function addBlog( Page $home, string $blogId ) : static
    {
        $cover = $this->img( 'editor' );

        $blog = $this->page( [
            'id' => $blogId,
            'lang' => 'en',
            'name' => 'Journal',
            'title' => 'PagibleAI Journal',
            'path' => 'blog',
            'tag' => 'blog',
            'type' => 'blog',
            'status' => 1,
        ], [
            ['id' => Utils::uid(), 'type' => 'hero', 'group' => 'main', 'data' => [
                'title' => 'Notes on running a modern content stack',
                'subtitle' => 'PagibleAI Journal',
                'text' => 'Practical writing about editorial systems, structured content, Laravel delivery, and the careful use of AI inside a publishing workflow.',
            ]],
            ['id' => Utils::uid(), 'type' => 'blog', 'group' => 'main', 'data' => [
                'title' => 'Recent articles',
                'layout' => 'list',
                'limit' => 4,
                'order' => '_lft',
                'parent-page' => ['value' => $blogId, 'label' => 'Journal'],
            ]],
        ], $home, [], [
            ['type' => 'meta-tags', 'data' => [
                'description' => 'The PagibleAI journal covers editorial workflows, structured content, Laravel delivery, and responsible AI assistance.',
                'keywords' => 'PagibleAI CMS journal, Laravel CMS, structured content, editorial workflow',
            ]],
            ['type' => 'social-media', 'data' => [
                'title' => 'PagibleAI Journal',
                'description' => 'Working notes for editors and developers who share responsibility for a website.',
                'file' => ['id' => $cover, 'type' => 'file'],
            ]],
        ] );

        $this->page( [
            'lang' => 'en',
            'name' => 'A draft should never overwrite a live page',
            'title' => 'A Draft Should Never Overwrite a Live Page | PagibleAI',
            'path' => 'a-draft-should-never-overwrite-a-live-page',
            'tag' => 'article',
            'type' => 'blog',
            'status' => 1,
        ], [
            $this->article(
                'A draft should never overwrite a live page',
                "A routine edit should not put the public site at risk. Editors need room to revise a page, compare versions, and ask for review while readers continue to see the approved copy.\n\nPagibleAI stores each revision as an immutable snapshot. The editor works on the latest version; the website reads the published one. Those two states only meet when someone with the right permission publishes the draft.",
                $this->img( 'version' )
            ),
            ['id' => Utils::uid(), 'type' => 'image-text', 'group' => 'main', 'data' => [
                'file' => ['id' => $this->img( 'publish' ), 'type' => 'file'],
                'position' => 'end',
                'ratio' => '1-2',
                'text' => "## Treat publishing as a decision\n\nA useful review shows the proposed content, the person who changed it, and the version currently online. The reviewer should not have to reconstruct that history from messages or browser tabs.\n\nPagibleAI keeps drafts, scheduled versions, published snapshots, and restored revisions in the same record. You can move forward or restore an earlier version without changing the audit trail.",
            ]],
            ['id' => Utils::uid(), 'type' => 'table', 'group' => 'main', 'data' => [
                'title' => 'What each state is for',
                'header' => 'row',
                'table' => [
                    ['State', 'Who sees it', 'Typical use'],
                    ['Draft', 'Editors with access', 'Writing, layout changes, internal review'],
                    ['Scheduled', 'Editors until its publish time', 'Campaigns and dated announcements'],
                    ['Published', 'Public readers and delivery APIs', 'The approved website'],
                    ['Restored', 'Editors until republished', 'Returning to a known revision'],
                ],
            ]],
            ['id' => Utils::uid(), 'type' => 'text', 'group' => 'main', 'data' => [
                'text' => "This separation becomes more valuable as the team grows. Writers can keep moving, publishers retain control, and developers do not need to invent a parallel staging system for ordinary content changes.",
            ]],
            $this->articleHero( 'Keep the live page stable', 'Set up a publishing flow where drafts remain editable and every public change has a clear version.' ),
        ], $blog );

        $this->page( [
            'lang' => 'en',
            'name' => 'Give structured content a shape editors can use',
            'title' => 'Give Structured Content a Shape Editors Can Use | PagibleAI',
            'path' => 'give-structured-content-a-shape-editors-can-use',
            'tag' => 'article',
            'type' => 'blog',
            'status' => 1,
        ], [
            $this->article(
                'Give structured content a shape editors can use',
                "A content model is only useful when an editor can understand it without reading the implementation. Field names should match the job at hand. Constraints should prevent real mistakes. Optional fields should remain optional.\n\nPagibleAI defines elements in JSON schema and renders them with Blade. Editors get a focused form; developers keep a small, reviewable contract between stored content and the frontend.",
                $this->img( 'model' )
            ),
            ['id' => Utils::uid(), 'type' => 'code', 'group' => 'main', 'data' => [
                'language' => ['value' => 'json'],
                'text' => "{\n  \"testimonial\": {\n    \"label\": \"Testimonial\",\n    \"fields\": {\n      \"quote\": {\"type\": \"text\", \"required\": true},\n      \"name\": {\"type\": \"string\", \"required\": true},\n      \"role\": {\"type\": \"string\"},\n      \"image\": {\"type\": \"image\"}\n    }\n  }\n}",
            ]],
            ['id' => Utils::uid(), 'type' => 'cards', 'group' => 'main', 'data' => [
                'title' => 'A model has three readers',
                'cards' => [
                    ['title' => 'The editor', 'text' => 'Needs plain labels, sensible defaults, and enough structure to avoid cleanup later.', 'file' => ['id' => $this->img( 'content' ), 'type' => 'file']],
                    ['title' => 'The frontend', 'text' => 'Needs a stable data shape that a Blade view or API client can render without guesswork.', 'file' => ['id' => $this->img( 'editor' ), 'type' => 'file']],
                    ['title' => 'The next developer', 'text' => 'Needs a schema small enough to review and extend without tracing hidden conventions.', 'file' => ['id' => $this->img( 'team' ), 'type' => 'file']],
                ],
            ]],
            ['id' => Utils::uid(), 'type' => 'text', 'group' => 'main', 'data' => [
                'text' => "Start with the content that must remain reusable: headings, text, media, links, and repeatable items. Add presentation choices only when an editor genuinely needs them. A narrow model is easier to migrate, translate, search, and deliver through an API.",
            ]],
            $this->articleHero( 'Model the content your team already understands', 'Follow a concrete example from schema definition to editable field and Blade output.' ),
        ], $blog );

        $this->page( [
            'lang' => 'en',
            'name' => 'Where AI belongs in editorial work',
            'title' => 'Where AI Belongs in Editorial Work | PagibleAI',
            'path' => 'where-ai-belongs-in-editorial-work',
            'tag' => 'article',
            'type' => 'blog',
            'status' => 1,
        ], [
            $this->article(
                'Where AI belongs in editorial work',
                "AI is useful when it removes a mechanical step and leaves the editorial decision visible. It is less useful when it hides where a claim came from or turns a specific page into interchangeable copy.\n\nPagibleAI places writing, refinement, translation, image work, and transcription inside the editor. The result is still a draft. You review it in context and publish it through the same versioned workflow as any other change.",
                $this->img( 'workflow' )
            ),
            ['id' => Utils::uid(), 'type' => 'table', 'group' => 'main', 'data' => [
                'title' => 'Use assistance where review is straightforward',
                'header' => 'row',
                'table' => [
                    ['Task', 'A useful starting point', 'Editorial check'],
                    ['Drafting', 'Outline or first paragraph from an approved brief', 'Facts, voice, and omissions'],
                    ['Translation', 'A complete draft in the target language', 'Terminology, locale, and links'],
                    ['Image editing', 'Crop, background removal, or extension', 'Rights, accuracy, and composition'],
                    ['Description', 'Alt text or media summary', 'What the image contributes in context'],
                    ['Transcription', 'Timed speech converted to text', 'Names, numbers, and technical terms'],
                ],
            ]],
            ['id' => Utils::uid(), 'type' => 'image-text', 'group' => 'main', 'data' => [
                'file' => ['id' => $this->img( 'media' ), 'type' => 'file'],
                'position' => 'start',
                'ratio' => '1-2',
                'text' => "## Keep providers interchangeable\n\nDifferent jobs call for different providers. PagibleAI lets you configure writing, translation, transcription, description, and image operations separately. You can change the provider or model for one task without rebuilding the editorial interface.\n\nThat boundary also keeps credentials and operational choices in Laravel configuration, where your development team can review them.",
            ]],
            ['id' => Utils::uid(), 'type' => 'text', 'group' => 'main', 'data' => [
                'text' => "The measure of a good integration is not how often the model appears. It is whether the editor reaches a stronger draft with less copying between tools, while retaining a clear point at which a person accepts the work.",
            ]],
            $this->articleHero( 'Configure assistance around your workflow', 'Choose providers per task and keep generated work inside the normal review and publishing path.' ),
        ], $blog );

        $this->page( [
            'lang' => 'en',
            'name' => 'One content base, several delivery paths',
            'title' => 'One Content Base, Several Delivery Paths | PagibleAI',
            'path' => 'one-content-base-several-delivery-paths',
            'tag' => 'article',
            'type' => 'blog',
            'status' => 1,
        ], [
            $this->article(
                'One content base, several delivery paths',
                "The website, a mobile client, an internal tool, and an automation agent should not need separate copies of the same page. They need interfaces suited to their jobs, backed by one published content record.\n\nPagibleAI renders Laravel sites with Blade, exposes published content through a read-only JSON:API, provides GraphQL for administration, and includes MCP tools for controlled content operations.",
                $this->img( 'api' )
            ),
            ['id' => Utils::uid(), 'type' => 'table', 'group' => 'main', 'data' => [
                'title' => 'Choose the interface by responsibility',
                'header' => 'row',
                'table' => [
                    ['Interface', 'Best suited to', 'Access pattern'],
                    ['Blade themes', 'Laravel websites and server-rendered pages', 'Published page tree'],
                    ['JSON:API', 'Apps and frontend clients', 'Read-only published content'],
                    ['GraphQL', 'Admin interfaces and integrations', 'Queries and controlled mutations'],
                    ['MCP tools', 'Agent-assisted content operations', 'Permission-checked CMS actions'],
                ],
            ]],
            ['id' => Utils::uid(), 'type' => 'code', 'group' => 'main', 'data' => [
                'language' => ['value' => 'graphql'],
                'text' => "query PublishedPage {\n  page(path: \"company/about\") {\n    id\n    title\n    lang\n    content\n    files { id mime path description }\n  }\n}",
            ]],
            ['id' => Utils::uid(), 'type' => 'image-text', 'group' => 'main', 'data' => [
                'file' => ['id' => $this->img( 'global' ), 'type' => 'file'],
                'position' => 'end',
                'ratio' => '1-2',
                'text' => "## Preserve one publishing boundary\n\nEach delivery path should respect the same published version, tenant boundary, language, and permissions. That gives editors one place to correct content and gives developers an explicit contract for every consumer.\n\nWhen a page is published, search and delivery clients can work from the approved snapshot rather than an editor's unfinished revision.",
            ]],
            $this->articleHero( 'Pick the right delivery surface', 'See how the theme renderer, JSON:API, GraphQL, and MCP packages divide their responsibilities.' ),
        ], $blog );

        return $this;
    }


    /**
     * Creates the documentation section below the home page.
     *
     * @param Page $home Home page
     * @return static Same object for fluent calls
     */
    protected function addDocs( Page $home ) : static
    {
        $diagram = $this->img( 'model' );

        $docs = $this->page( [
            'lang' => 'en',
            'name' => 'Documentation',
            'title' => 'PagibleAI CMS Documentation',
            'path' => 'docs',
            'type' => 'docs',
            'status' => 1,
        ], [
            ['id' => Utils::uid(), 'type' => 'toc', 'group' => 'main', 'data' => [
                'title' => 'On this page',
            ]],
            ['id' => Utils::uid(), 'type' => 'heading', 'group' => 'main', 'data' => [
                'level' => 2,
                'title' => 'Install PagibleAI in a Laravel application',
            ]],
            ['id' => Utils::uid(), 'type' => 'text', 'group' => 'main', 'data' => [
                'text' => "PagibleAI installs into an existing Laravel 11, 12, or 13 application. The installer adds the CMS packages and configuration; migrations create the page, element, file, version, and search tables.\n\nStart with a clean branch and a database backup when adding the CMS to an established application. The package uses your Laravel database, filesystem, queue, cache, authentication, and deployment process.",
            ]],
            ['id' => Utils::uid(), 'type' => 'code', 'group' => 'main', 'data' => [
                'language' => ['value' => 'bash'],
                'text' => "composer require aimeos/pagible\nphp artisan cms:install\nphp artisan migrate\nphp artisan cms:user -e editor@example.com",
            ]],
            ['id' => Utils::uid(), 'type' => 'table', 'group' => 'main', 'data' => [
                'title' => 'Package responsibilities',
                'header' => 'row',
                'table' => [
                    ['Package', 'Responsibility', 'Use it when'],
                    ['Core', 'Models, versions, permissions, tenancy', 'Every installation'],
                    ['Admin', 'Vue editing interface', 'People edit content in a browser'],
                    ['Theme', 'Blade rendering and page cache', 'Laravel serves the website'],
                    ['GraphQL', 'Administrative API', 'An application manages CMS records'],
                    ['JSON:API', 'Published content delivery', 'A frontend reads content remotely'],
                    ['AI', 'Writing, translation, media operations', 'Editors need configured assistance'],
                    ['Search', 'Database-native full-text index', 'Readers search the website'],
                    ['MCP', 'Permission-checked content tools', 'Agents assist with CMS work'],
                ],
            ]],
            ['id' => Utils::uid(), 'type' => 'cards', 'group' => 'main', 'data' => [
                'title' => 'Working examples',
                'cards' => [
                    ['title' => 'Build a content element', 'text' => "Define one reusable content shape, render it with Blade, and make it available to editors.\n\n[Open the content element example](/docs/build-a-content-element)", 'file' => ['id' => $this->img( 'content' ), 'type' => 'file']],
                    ['title' => 'Configure editorial AI', 'text' => "Assign a provider and model to each editorial task without coupling the CMS to one service.\n\n[Open the AI configuration example](/docs/configure-editorial-ai)", 'file' => ['id' => $this->img( 'workflow' ), 'type' => 'file']],
                ],
            ]],
            ['id' => Utils::uid(), 'type' => 'heading', 'group' => 'main', 'data' => [
                'level' => 2,
                'title' => 'Publish with explicit roles',
            ]],
            ['id' => Utils::uid(), 'type' => 'image-text', 'group' => 'main', 'data' => [
                'file' => ['id' => $this->img( 'publish' ), 'type' => 'file'],
                'position' => 'start',
                'ratio' => '1-2',
                'text' => "PagibleAI separates viewing, editing, publishing, and administration permissions. Named role definitions expand into permission sets, so a small site can use simple roles while a larger installation can assign narrower capabilities.\n\nEvery save creates a version. Publishing selects the snapshot that public routes and delivery APIs may read. Schedule the `cms:publish` command when your team uses timed releases.",
            ]],
            ['id' => Utils::uid(), 'type' => 'file', 'group' => 'main', 'data' => [
                'file' => ['id' => $this->guideFile(), 'type' => 'file'],
            ]],
        ], $home, [$diagram], [
            ['type' => 'meta-tags', 'data' => [
                'description' => 'Install PagibleAI CMS, choose packages, define content, configure permissions, and publish from a Laravel application.',
                'keywords' => 'PagibleAI documentation, Laravel CMS installation, structured content, CMS API',
            ]],
            ['type' => 'social-media', 'data' => [
                'title' => 'PagibleAI CMS Documentation',
                'description' => 'Installation and working examples for editors and Laravel developers.',
                'file' => ['id' => $diagram, 'type' => 'file'],
            ]],
        ] );

        $this->page( [
            'lang' => 'en',
            'name' => 'Build a content element',
            'title' => 'Build a Content Element | PagibleAI Documentation',
            'path' => 'docs/build-a-content-element',
            'type' => 'docs',
            'status' => 1,
        ], [
            ['id' => Utils::uid(), 'type' => 'toc', 'group' => 'main', 'data' => ['title' => 'On this page']],
            ['id' => Utils::uid(), 'type' => 'heading', 'group' => 'main', 'data' => ['level' => 2, 'title' => 'Define the editor contract']],
            ['id' => Utils::uid(), 'type' => 'text', 'group' => 'main', 'data' => [
                'text' => "A content element starts with a schema entry. The schema names the element, groups its fields, and tells the admin which input control to show. Keep the stored data about meaning rather than layout whenever possible.\n\nThe example below defines a release note with a title, summary, release date, and optional link. It is narrow enough for an editor to complete correctly and stable enough for several frontends to consume.",
            ]],
            ['id' => Utils::uid(), 'type' => 'code', 'group' => 'main', 'data' => [
                'language' => ['value' => 'json'],
                'text' => "{\n  \"release-note\": {\n    \"label\": \"Release note\",\n    \"fields\": {\n      \"title\": {\"type\": \"string\", \"required\": true},\n      \"summary\": {\"type\": \"markdown\", \"required\": true},\n      \"released\": {\"type\": \"date\", \"required\": true},\n      \"url\": {\"type\": \"url\"}\n    }\n  }\n}",
            ]],
            ['id' => Utils::uid(), 'type' => 'heading', 'group' => 'main', 'data' => ['level' => 2, 'title' => 'Render the published data']],
            ['id' => Utils::uid(), 'type' => 'code', 'group' => 'main', 'data' => [
                'language' => ['value' => 'html'],
                'text' => <<<'HTML'
<article class="release-note">
  <time datetime="{{ cms($page, 'data.released') }}">
    {{ cms($page, 'data.released') }}
  </time>
  <h2>{{ cms($page, 'data.title') }}</h2>
  <div>{!! cmsmarkdown(cms($page, 'data.summary')) !!}</div>
</article>
HTML,
            ]],
            ['id' => Utils::uid(), 'type' => 'table', 'group' => 'main', 'data' => [
                'title' => 'Review before adding fields',
                'header' => 'row',
                'table' => [
                    ['Question', 'Prefer', 'Avoid'],
                    ['Does the field describe meaning?', 'released, summary, author', 'leftColumn, blueText'],
                    ['Can an editor choose correctly?', 'A short list of valid options', 'An unexplained free-form code'],
                    ['Will clients reuse it?', 'A stable value and explicit type', 'Markup tied to one template'],
                    ['Is it actually required?', 'Required only when rendering depends on it', 'Mandatory fields added for completeness'],
                ],
            ]],
        ], $docs );

        $this->page( [
            'lang' => 'en',
            'name' => 'Configure editorial AI',
            'title' => 'Configure Editorial AI | PagibleAI Documentation',
            'path' => 'docs/configure-editorial-ai',
            'type' => 'docs',
            'status' => 1,
        ], [
            ['id' => Utils::uid(), 'type' => 'toc', 'group' => 'main', 'data' => ['title' => 'On this page']],
            ['id' => Utils::uid(), 'type' => 'heading', 'group' => 'main', 'data' => ['level' => 2, 'title' => 'Configure tasks separately']],
            ['id' => Utils::uid(), 'type' => 'text', 'group' => 'main', 'data' => [
                'text' => "PagibleAI does not require one provider to handle every editorial task. Configure the service and model for writing, refinement, translation, descriptions, transcription, and image operations independently. Only add credentials for the features you enable.\n\nKeep secrets in environment variables. Commit the provider and model choices only when they are safe defaults for every deployment.",
            ]],
            ['id' => Utils::uid(), 'type' => 'code', 'group' => 'main', 'data' => [
                'language' => ['value' => 'bash'],
                'text' => "CMS_AI_WRITE=gemini\nCMS_AI_WRITE_MODEL=gemini-2.5-flash\nCMS_AI_WRITE_API_KEY=your-key\n\nCMS_AI_TRANSLATE=deepl\nCMS_AI_TRANSLATE_API_KEY=your-key\n\nCMS_AI_TRANSCRIBE=openai\nCMS_AI_TRANSCRIBE_MODEL=whisper-1\nCMS_AI_TRANSCRIBE_API_KEY=your-key",
            ]],
            ['id' => Utils::uid(), 'type' => 'table', 'group' => 'main', 'data' => [
                'title' => 'Operational checks',
                'header' => 'row',
                'table' => [
                    ['Check', 'Why it matters', 'Owner'],
                    ['Provider terms', 'Content may leave your infrastructure', 'Legal or security'],
                    ['Model choice', 'Quality, cost, and context limits vary', 'Product owner'],
                    ['Key scope', 'Limits damage from a leaked credential', 'Platform team'],
                    ['Human review', 'Generated work remains a draft', 'Publisher'],
                    ['Fallback behavior', 'Editors need a clear error when a service is unavailable', 'Development team'],
                ],
            ]],
            ['id' => Utils::uid(), 'type' => 'image-text', 'group' => 'main', 'data' => [
                'file' => ['id' => $this->img( 'security' ), 'type' => 'file'],
                'position' => 'end',
                'ratio' => '1-2',
                'text' => "## Keep the publishing decision human\n\nGenerated text, translations, and media enter the same draft and version workflow as manual changes. The provider does not publish a page. Your CMS permissions still determine who can approve the result and make it public.\n\nTest the configured task with representative content before enabling it for a wider editorial group.",
            ]],
        ], $docs );

        return $this;
    }


    /**
     * Creates an article lead element with the file reference used by previews.
     *
     * @param string $title Article title
     * @param string $text Article introduction
     * @param string $fileId Cover file ID
     * @return array<string, mixed> Article content element
     */
    protected function article( string $title, string $text, string $fileId ) : array
    {
        return ['id' => Utils::uid(), 'type' => 'article', 'group' => 'main', 'files' => [$fileId], 'data' => [
            'title' => $title,
            'file' => ['id' => $fileId, 'type' => 'file'],
            'text' => $text,
        ]];
    }


    /**
     * Creates the closing call-to-action hero for an article.
     *
     * @param string $title Hero title
     * @param string $text Hero text
     * @return array<string, mixed> Hero content element
     */
    protected function articleHero( string $title, string $text ) : array
    {
        return ['id' => Utils::uid(), 'type' => 'hero', 'group' => 'main', 'data' => [
            'title' => $title,
            'subtitle' => 'PagibleAI in practice',
            'text' => $text,
            'url' => '/docs',
            'button' => 'Open the documentation',
        ]];
    }


    /**
     * Creates the shared PagibleAI footer element and returns its ID.
     *
     * @return string Element ID
     */
    protected function element() : string
    {
        if( !isset( $this->element ) )
        {
            $cards = [
                ['title' => 'Product', 'text' => "- [Platform](/)\n- [Documentation](/docs)\n- [GitHub](https://github.com/aimeos/pagible)"],
                ['title' => 'For developers', 'text' => "- [Build a content element](/docs/build-a-content-element)\n- [Configure editorial AI](/docs/configure-editorial-ai)\n- [Journal](/blog)"],
                ['title' => 'Project', 'text' => "- MIT licensed\n- Laravel 11, 12 and 13\n- PHP 8.2+"],
            ];

            $element = Element::forceCreate( [
                'lang' => 'en',
                'type' => 'cards',
                'name' => 'PagibleAI footer',
                'data' => ['type' => 'cards', 'data' => ['cards' => $cards]],
                'editor' => 'demo',
            ] );

            $version = $element->versions()->forceCreate( [
                'lang' => 'en',
                'data' => [
                    'lang' => 'en',
                    'type' => 'cards',
                    'name' => 'PagibleAI footer',
                    'data' => ['cards' => $cards],
                ],
                'published' => true,
                'editor' => 'demo',
            ] );

            $element->forceFill( ['latest_id' => $version->id] )->saveQuietly();
            $element->publish( $version );
            $this->element = (string) $element->refresh()->id;
        }

        return $this->element;
    }


    /**
     * Returns the ID of the primary shared demo image.
     *
     * @return string File ID
     */
    protected function file() : string
    {
        return $this->img( 'editor' );
    }


    /**
     * Creates a downloadable implementation guide and returns its ID.
     *
     * @return string File ID
     */
    protected function guideFile() : string
    {
        if( !isset( $this->guideFile ) )
        {
            $data = [
                'mime' => 'application/pdf',
                'lang' => 'en',
                'name' => 'PagibleAI implementation checklist',
                'path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'previews' => [],
                'description' => ['en' => 'Downloadable checklist for planning a PagibleAI CMS installation'],
            ];

            $file = File::forceCreate( $data + ['editor' => 'demo'] );
            $version = $file->versions()->forceCreate( [
                'lang' => 'en',
                'data' => $data,
                'published' => true,
                'editor' => 'demo',
            ] );

            $file->forceFill( ['latest_id' => $version->id] )->saveQuietly();
            $file->publish( $version );
            $this->guideFile = (string) $file->refresh()->id;
        }

        return $this->guideFile;
    }


    /**
     * Creates the PagibleAI home page and returns it.
     *
     * @param string $blogId Journal page ID referenced by listing elements
     * @return Page Home page
     */
    protected function home( string $blogId ) : Page
    {
        $elementId = $this->element();
        $fileId = $this->file();

        $content = [
            ['id' => Utils::uid(), 'type' => 'hero', 'group' => 'main', 'data' => [
                'title' => 'A Laravel CMS your whole team can work with',
                'subtitle' => 'PagibleAI CMS',
                'text' => 'Give editors a clear publishing system and developers a compact, API-first foundation that fits the Laravel application you already run.',
                'url' => '/docs',
                'button' => 'Install PagibleAI',
                'url-alternative' => 'https://github.com/aimeos/pagible',
                'button-alternative' => 'View the source',
                'background' => ['id' => $this->img( 'global' ), 'type' => 'file'],
                'background-animation' => 'zoom',
                'files' => [
                    ['id' => $fileId, 'type' => 'file'],
                    ['id' => $this->img( 'content' ), 'type' => 'file'],
                    ['id' => $this->img( 'api' ), 'type' => 'file'],
                ],
            ]],
            ['id' => Utils::uid(), 'type' => 'cards', 'group' => 'main', 'data' => [
                'title' => 'One system, clear responsibilities',
                'cards' => [
                    ['title' => 'Editors shape and publish', 'text' => 'Build pages from defined content elements, keep drafts separate from the live site, schedule releases, and restore earlier versions.', 'file' => ['id' => $this->img( 'workflow' ), 'type' => 'file']],
                    ['title' => 'Developers keep Laravel', 'text' => 'Use Blade, Eloquent, queues, storage, cache, authentication, and the deployment practices already understood by your team.', 'file' => ['id' => $this->img( 'editor' ), 'type' => 'file']],
                    ['title' => 'Clients use published content', 'text' => 'Serve the website from a theme or deliver the same approved records through JSON:API and purpose-built integrations.', 'file' => ['id' => $this->img( 'api' ), 'type' => 'file']],
                ],
            ]],
            ['id' => Utils::uid(), 'type' => 'image-text', 'group' => 'main', 'data' => [
                'file' => ['id' => $this->img( 'publish' ), 'type' => 'file'],
                'position' => 'start',
                'ratio' => '1-2',
                'text' => "## Let editors work without touching the live version\n\nEvery change becomes an immutable version. Editors see the latest draft while public routes and delivery APIs continue to read the published snapshot. A publisher can review, schedule, restore, or approve the exact revision that should go online.\n\nShared elements keep recurring content in one place, and the page tree gives complex sites a navigation structure that remains understandable in the admin.",
            ]],
            ['id' => Utils::uid(), 'type' => 'table', 'group' => 'main', 'data' => [
                'title' => 'One content base, several ways to use it',
                'header' => 'row',
                'table' => [
                    ['Surface', 'What it provides', 'Typical reader'],
                    ['Theme renderer', 'Cached HTML from Blade views', 'Website visitors'],
                    ['JSON:API', 'Read-only published records', 'Web and mobile clients'],
                    ['GraphQL', 'Queries and CMS mutations', 'Admin applications and integrations'],
                    ['MCP server', '33 content and media tools', 'Authorized assistants and automations'],
                    ['Search engine', 'Database-native full-text search', 'Visitors and editors'],
                ],
            ]],
            ['id' => Utils::uid(), 'type' => 'image-text', 'group' => 'main', 'data' => [
                'file' => ['id' => $this->img( 'media' ), 'type' => 'file'],
                'position' => 'end',
                'ratio' => '1-2',
                'text' => "## Put AI beside the editorial controls\n\nEditors can draft and refine text, translate content, describe media, transcribe audio, and perform focused image operations without moving work through unrelated tools. Each task can use its own configured provider and model.\n\nAssisted work enters the page as a draft. Your permissions, review process, and published version remain the authority.",
            ]],
            ['id' => Utils::uid(), 'type' => 'cards', 'group' => 'main', 'data' => [
                'title' => 'Built for the work around publishing',
                'cards' => [
                    ['title' => 'Multiple sites and languages', 'text' => 'Run separate page trees by domain, keep tenant data scoped in one shared database, and publish localized content from the same model.', 'file' => ['id' => $this->img( 'global' ), 'type' => 'file']],
                    ['title' => 'Search on your database', 'text' => 'Use SQLite FTS5, MySQL full text, PostgreSQL tsvector, or SQL Server CONTAINSTABLE through one Scout engine.', 'file' => ['id' => $this->img( 'search' ), 'type' => 'file']],
                    ['title' => 'Security in the normal path', 'text' => 'Sanitize submitted HTML, enforce CSP headers, validate URLs, throttle endpoints, and apply tenant-aware permissions.', 'file' => ['id' => $this->img( 'security' ), 'type' => 'file']],
                ],
            ]],
            ['id' => Utils::uid(), 'type' => 'testimonial', 'group' => 'main', 'data' => [
                'title' => 'Made for teams that share ownership of the site',
                'items' => [
                    ['name' => 'Leonie Hartmann', 'role' => 'Editorial Director, Kante Studio', 'text' => 'Our editors can prepare a release without wondering what is already public. The version boundary is obvious, and the page tree feels familiar on the first day.'],
                    ['name' => 'Samir Patel', 'role' => 'Lead Developer, Northstar Works', 'text' => 'We kept Laravel in charge of the application and added the CMS where it belonged. There was no second platform to operate or work around.'],
                    ['name' => 'Maya Chen', 'role' => 'Content Operations, Relay House', 'text' => 'Translation and media descriptions now happen inside the draft. Review still belongs to our team, which made the rollout easy to explain.'],
                ],
            ]],
            ['id' => Utils::uid(), 'type' => 'blog', 'group' => 'main', 'data' => [
                'title' => 'From the journal',
                'layout' => 'cards',
                'limit' => 2,
                'order' => '_lft',
                'parent-page' => ['value' => $blogId, 'label' => 'Journal'],
            ]],
            ['id' => Utils::uid(), 'type' => 'questions', 'group' => 'main', 'data' => [
                'title' => 'Before you install',
                'items' => [
                    ['title' => 'Can PagibleAI be added to an existing Laravel application?', 'text' => 'Yes. PagibleAI is installed as Composer packages and uses the application\'s existing database, storage, cache, queue, and authentication services.'],
                    ['title' => 'Does AI-generated content publish automatically?', 'text' => 'No. Generated and translated content remains part of the editable draft. Publishing still requires the permissions and action defined by your workflow.'],
                    ['title' => 'Can one installation serve several sites?', 'text' => 'Yes. Multi-domain routing can select separate page trees, and single-database tenant scopes keep records separated when you run more than one tenant.'],
                    ['title' => 'Which databases support full-text search?', 'text' => 'The search package supports SQLite, MySQL, PostgreSQL, and SQL Server using the native full-text features of each database.'],
                    ['title' => 'Is PagibleAI open source?', 'text' => 'Yes. PagibleAI CMS is released under the MIT license.'],
                ],
            ]],
            ['id' => 'contact', 'type' => 'contact', 'group' => 'main', 'data' => [
                'title' => 'Tell us what your publishing workflow needs',
            ]],
            ['id' => Utils::uid(), 'type' => 'heading', 'group' => 'footer', 'data' => ['level' => 2, 'title' => 'PagibleAI CMS']],
            ['type' => 'reference', 'refid' => $elementId, 'group' => 'footer'],
        ];

        $meta = [
            ['type' => 'meta-tags', 'data' => [
                'description' => 'PagibleAI is an API-first Laravel CMS for structured content, versioned publishing, AI-assisted editorial work, themes, search, and multi-site delivery.',
                'keywords' => 'PagibleAI CMS, Laravel CMS, API-first CMS, structured content, AI content management',
            ]],
            ['type' => 'social-media', 'data' => [
                'title' => 'PagibleAI CMS for Laravel',
                'description' => 'A clear publishing system for editors and a compact Laravel foundation for developers.',
                'file' => ['id' => $fileId, 'type' => 'file'],
            ]],
        ];

        $page = Page::forceCreate( [
            'lang' => 'en',
            'name' => 'Home',
            'title' => 'PagibleAI CMS for Laravel',
            'path' => '',
            'tag' => 'root',
            'theme' => $this->theme,
            'status' => 1,
            'cache' => 5,
            'editor' => 'demo',
            'meta' => $meta,
            'content' => $content,
        ] );

        $version = $page->versions()->forceCreate( [
            'lang' => 'en',
            'data' => [
                'name' => 'Home',
                'title' => 'PagibleAI CMS for Laravel',
                'path' => '',
                'tag' => 'root',
                'domain' => '',
                'theme' => $this->theme,
                'status' => 1,
                'cache' => 5,
            ],
            'aux' => [
                'meta' => $meta,
                'content' => $content,
            ],
            'published' => true,
            'editor' => 'demo',
        ] );

        $version->files()->attach( array_unique( array_merge( [$fileId], $this->ids( $content ), $this->ids( $meta ) ) ) );
        $version->elements()->attach( $elementId );
        $page->forceFill( ['latest_id' => $version->id] )->saveQuietly();
        $page->publish( $version );

        return $page;
    }


    /**
     * Returns file IDs referenced anywhere in the given data.
     *
     * @param mixed $value Content or meta data
     * @return array<int, string> File IDs
     */
    protected function ids( mixed $value ) : array
    {
        $ids = [];

        if( is_array( $value ) )
        {
            if( ( $value['type'] ?? null ) === 'file' && is_string( $value['id'] ?? null )
                && !isset( $value['data'] ) && !isset( $value['group'] )
            ) {
                $ids[] = $value['id'];
            }

            foreach( $value as $item ) {
                $ids = array_merge( $ids, $this->ids( $item ) );
            }
        }

        return $ids;
    }


    /**
     * Returns the file ID for a curated demo photo.
     *
     * @param string $key Photo key from self::PHOTOS
     * @return string File ID
     */
    protected function img( string $key ) : string
    {
        [$photo, $name, $desc] = self::PHOTOS[$key];
        return $this->image( $photo, $name, $desc );
    }


    /**
     * Creates a demo page below the given parent and returns it.
     *
     * @param array<string, mixed> $data Page attributes
     * @param array<int, array<string, mixed>> $content Content elements
     * @param Page $parent Parent page to append to
     * @param array<int, string> $fileIds Additional file IDs to attach
     * @param array<int, array<string, mixed>> $meta Meta data blocks
     * @return Page Created page
     */
    protected function page( array $data, array $content, Page $parent, array $fileIds = [], array $meta = [] ) : Page
    {
        $elementId = $this->element();
        $fileId = $this->file();

        $meta = $data['meta'] ?? $meta ?: [
            ['type' => 'meta-tags', 'data' => [
                'description' => $data['title'] ?? '',
                'keywords' => 'PagibleAI CMS, Laravel CMS, structured content, publishing',
            ]],
            ['type' => 'social-media', 'data' => [
                'title' => $data['title'] ?? '',
                'description' => $data['title'] ?? '',
                'file' => ['id' => $fileId, 'type' => 'file'],
            ]],
        ];

        $content[] = ['id' => Utils::uid(), 'type' => 'heading', 'group' => 'footer', 'data' => ['level' => 2, 'title' => 'PagibleAI CMS']];
        $content[] = ['type' => 'reference', 'refid' => $elementId, 'group' => 'footer'];

        $page = Page::forceCreate( $data + [
            'theme' => $this->theme,
            'editor' => 'demo',
            'meta' => $meta,
            'content' => $content,
        ] );
        $page->appendToNode( $parent )->save();

        $version = $page->versions()->forceCreate( [
            'lang' => $data['lang'] ?? 'en',
            'data' => array_diff_key( $data, ['content' => 1, 'meta' => 1, 'id' => 1] ) + [
                'domain' => '',
                'theme' => $this->theme,
            ],
            'aux' => ['meta' => $meta, 'content' => $content],
            'published' => true,
            'editor' => 'demo',
        ] );

        $version->elements()->attach( $elementId );
        $version->files()->attach( array_unique( array_merge( [$fileId], $fileIds, $this->ids( $content ), $this->ids( $meta ) ) ) );

        $page->forceFill( ['latest_id' => $version->id] )->saveQuietly();
        $page->publish( $version );

        return $page;
    }


    /**
     * Builds the Pagible theme demo page tree.
     */
    protected function pages() : void
    {
        $blogId = (string) Str::uuid7();
        $home = $this->home( $blogId );

        $this->addDocs( $home )
            ->addBlog( $home, $blogId );
    }
}
