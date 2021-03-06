<?php

namespace App\Http\Controllers;

use App\Support\MarkdownParser;
use Illuminate\View\View;
use App\Support\Documentation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Illuminate\Contracts\Foundation\Application;

class DocsController extends Controller
{
    protected const DEFAULT_PAGE = 'installation';
    protected const EXCLUDED = ['readme', 'license'];

    /**
     * @var MarkdownParser
     */
    protected MarkdownParser $markdownParser;

    public function __construct(MarkdownParser $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    /**
     * Handle the incoming request.
     *
     * @param Documentation $docs
     * @param string|null $page
     * @return Application|Factory|View|RedirectResponse
     */
    public function __invoke(Documentation $docs, string $page = null)
    {
        if ($page === null) {
            return redirect()->route('docs', [self::DEFAULT_PAGE]);
        }

        if (! $docs->exists(config('site.defaultVersion'), $page) || in_array($page, self::EXCLUDED)) {
            abort(404);
        }

        $index = $docs->getIndex(config('site.defaultVersion'));

        $file = $docs->get(config('site.defaultVersion'), $page);
        $contents = YamlFrontMatter::parse($file);
        $matter = $contents->matter();
        $markdown = $contents->body();

        $body = $this->markdownParser->convertToHtml($markdown);

        return view('docs', compact('body', 'matter', 'markdown', 'page', 'index'));
    }
}
