{!! $phptag !!}
/**
 * Created by {{ $author }}
 * Date: {{ $date }}
 */

namespace {{$namespace}};
use App\Components\Model\BaseModel;


/**
 * Class {{ $modelName }}
 * @author {{ $author }}
 * @package {{ $namespace }}
 * {{ $property }}
 *
 */
class {{$modelName}} extends BaseModel
{
    {!! str_replace('dove_', '', $table) !!}

}

